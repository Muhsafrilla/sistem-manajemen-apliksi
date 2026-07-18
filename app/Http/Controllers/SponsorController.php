<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    public function index()
    {
        return view('sponsor.index', [
            'title'    => 'Manajemen Sponsor',
            'sponsors' => Sponsor::with('events')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('sponsor.create', [
            'title'  => 'Tambah Sponsor',
            'events' => Event::orderBy('title')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'     => 'required|string|max:255',
            'tier'     => 'required|string|max:255',
            'contact'  => 'nullable|string|max:255',
            'logo_url' => 'nullable|image|max:2048',
            'events'   => 'nullable|array',
            'events.*' => 'exists:events,id',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('logo_url')) {
                $validate['logo_url'] = $request->file('logo_url')->store('sponsors', 'public');
            }

            $sponsor = Sponsor::create($validate);
            
            if ($request->has('events')) {
                $sponsor->events()->sync($request->events);
            }

            DB::commit();
            return to_route('sponsors.index')->withSuccess('Sponsor berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('sponsors.create')->withError('Gagal menambahkan sponsor: ' . $e->getMessage());
        }
    }

    public function edit(Sponsor $sponsor)
    {
        return view('sponsor.edit', [
            'title'   => 'Edit Sponsor',
            'sponsor' => $sponsor,
            'events'  => Event::orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, Sponsor $sponsor)
    {
        $validate = $request->validate([
            'name'     => 'required|string|max:255',
            'tier'     => 'required|string|max:255',
            'contact'  => 'nullable|string|max:255',
            'logo_url' => 'nullable|image|max:2048',
            'events'   => 'nullable|array',
            'events.*' => 'exists:events,id',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('logo_url')) {
                if ($sponsor->logo_url) {
                    Storage::disk('public')->delete($sponsor->logo_url);
                }
                $validate['logo_url'] = $request->file('logo_url')->store('sponsors', 'public');
            }

            $sponsor->update($validate);

            if ($request->has('events')) {
                $sponsor->events()->sync($request->events);
            } else {
                $sponsor->events()->detach();
            }

            DB::commit();
            return to_route('sponsors.index')->withSuccess('Sponsor berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('sponsors.edit', $sponsor)->withError('Gagal mengubah sponsor: ' . $e->getMessage());
        }
    }

    public function destroy(Sponsor $sponsor)
    {
        DB::beginTransaction();

        try {
            if ($sponsor->logo_url) {
                Storage::disk('public')->delete($sponsor->logo_url);
            }
            $sponsor->events()->detach();
            $sponsor->delete();
            DB::commit();
            return to_route('sponsors.index')->withSuccess('Sponsor berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('sponsors.index')->withError('Gagal menghapus sponsor: ' . $e->getMessage());
        }
    }
}
