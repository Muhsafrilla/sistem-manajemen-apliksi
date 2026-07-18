<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use App\Models\User;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index()
    {
        return view('organizer.index', [
            'title' => 'Organizer (Penyelenggara)',
            'organizers' => Organizer::with('user')->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('organizer.create', [
            'title' => 'Tambah Organizer',
            'users' => User::where('role', 'Organizer')->doesntHave('organizer')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'user_id' => 'required|exists:users,id|unique:organizers,user_id',
            'company_name' => 'required|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ], [
            'user_id.required' => 'User (Organizer) wajib dipilih',
            'user_id.unique' => 'User tersebut sudah memiliki profil organizer',
            'user_id.exists' => 'User tidak ditemukan',
            'company_name.required' => 'Nama perusahaan/organisasi wajib diisi',
            'contact_email.email' => 'Format email tidak valid',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            Organizer::create($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('organizers.index')->withSuccess('Organizer berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('organizers.create')->withError('Gagal menambahkan organizer: ' . $e->getMessage());
        }
    }

    public function edit(Organizer $organizer)
    {
        return view('organizer.edit', [
            'title' => 'Edit Organizer',
            'organizer' => $organizer,
            'users' => User::where('role', 'Organizer')->get(),
        ]);
    }

    public function update(Request $request, Organizer $organizer)
    {
        $validate = $request->validate([
            'user_id' => 'required|exists:users,id|unique:organizers,user_id,' . $organizer->id,
            'company_name' => 'required|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
        ], [
            'user_id.required' => 'User (Organizer) wajib dipilih',
            'user_id.unique' => 'User tersebut sudah memiliki profil organizer',
            'user_id.exists' => 'User tidak ditemukan',
            'company_name.required' => 'Nama perusahaan/organisasi wajib diisi',
            'contact_email.email' => 'Format email tidak valid',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $organizer->update($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('organizers.index')->withSuccess('Organizer berhasil diubah');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('organizers.edit', $organizer)->withError('Gagal mengubah organizer: ' . $e->getMessage());
        }
    }

    public function destroy(Organizer $organizer)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $organizer->delete();
            \Illuminate\Support\Facades\DB::commit();
            return to_route('organizers.index')->withSuccess('Organizer berhasil dihapus');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('organizers.index')->withError('Gagal menghapus organizer: ' . $e->getMessage());
        }
    }
}
