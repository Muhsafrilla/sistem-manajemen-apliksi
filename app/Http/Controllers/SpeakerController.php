<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SpeakerController extends Controller
{
    public function index()
    {
        return view('speaker.index', [
            'title'    => 'Manajemen Pembicara',
            'speakers' => Speaker::with('events')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('speaker.create', [
            'title'  => 'Tambah Pembicara',
            'events' => Event::orderBy('title')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'      => 'required|string|max:255',
            'company'   => 'nullable|string|max:255',
            'contact'   => 'nullable|string|max:255',
            'bio'       => 'nullable|string',
            'photo_url' => 'nullable|image|max:2048',
            'events'    => 'nullable|array',
            'events.*'  => 'exists:events,id',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('photo_url')) {
                $validate['photo_url'] = $request->file('photo_url')->store('speakers', 'public');
            }

            $speaker = Speaker::create($validate);
            
            if ($request->has('events')) {
                $speaker->events()->sync($request->events);
            }

            DB::commit();
            return to_route('speakers.index')->withSuccess('Pembicara berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('speakers.create')->withError('Gagal menambahkan pembicara: ' . $e->getMessage());
        }
    }

    public function edit(Speaker $speaker)
    {
        return view('speaker.edit', [
            'title'   => 'Edit Pembicara',
            'speaker' => $speaker,
            'events'  => Event::orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, Speaker $speaker)
    {
        $validate = $request->validate([
            'name'      => 'required|string|max:255',
            'company'   => 'nullable|string|max:255',
            'contact'   => 'nullable|string|max:255',
            'bio'       => 'nullable|string',
            'photo_url' => 'nullable|image|max:2048',
            'events'    => 'nullable|array',
            'events.*'  => 'exists:events,id',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('photo_url')) {
                if ($speaker->photo_url) {
                    Storage::disk('public')->delete($speaker->photo_url);
                }
                $validate['photo_url'] = $request->file('photo_url')->store('speakers', 'public');
            }

            $speaker->update($validate);

            if ($request->has('events')) {
                $speaker->events()->sync($request->events);
            } else {
                $speaker->events()->detach();
            }

            DB::commit();
            return to_route('speakers.index')->withSuccess('Pembicara berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('speakers.edit', $speaker)->withError('Gagal mengubah pembicara: ' . $e->getMessage());
        }
    }

    public function destroy(Speaker $speaker)
    {
        DB::beginTransaction();

        try {
            if ($speaker->photo_url) {
                Storage::disk('public')->delete($speaker->photo_url);
            }
            $speaker->events()->detach();
            $speaker->delete();
            DB::commit();
            return to_route('speakers.index')->withSuccess('Pembicara berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('speakers.index')->withError('Gagal menghapus pembicara: ' . $e->getMessage());
        }
    }
}
