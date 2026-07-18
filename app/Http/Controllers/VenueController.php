<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        return view('venue.index', [
            'title' => 'Venue / Lokasi',
            'venues' => Venue::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('venue.create', [
            'title' => 'Tambah Venue',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255|unique:venues,name',
            'address' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
        ], [
            'name.required' => 'Nama venue wajib diisi',
            'name.unique' => 'Nama venue sudah ada',
            'capacity.required' => 'Kapasitas wajib diisi',
            'capacity.integer' => 'Kapasitas harus berupa angka',
            'capacity.min' => 'Kapasitas minimal 1',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            Venue::create($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('venues.index')->withSuccess('Venue berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('venues.create')->withError('Gagal menambahkan venue: ' . $e->getMessage());
        }
    }

    public function edit(Venue $venue)
    {
        return view('venue.edit', [
            'title' => 'Edit Venue',
            'venue' => $venue,
        ]);
    }

    public function update(Request $request, Venue $venue)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255|unique:venues,name,' . $venue->id,
            'address' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
        ], [
            'name.required' => 'Nama venue wajib diisi',
            'name.unique' => 'Nama venue sudah ada',
            'capacity.required' => 'Kapasitas wajib diisi',
            'capacity.integer' => 'Kapasitas harus berupa angka',
            'capacity.min' => 'Kapasitas minimal 1',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $venue->update($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('venues.index')->withSuccess('Venue berhasil diubah');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('venues.edit', $venue)->withError('Gagal mengubah venue: ' . $e->getMessage());
        }
    }

    public function destroy(Venue $venue)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $venue->delete();
            \Illuminate\Support\Facades\DB::commit();
            return to_route('venues.index')->withSuccess('Venue berhasil dihapus');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('venues.index')->withError('Gagal menghapus venue: ' . $e->getMessage());
        }
    }
}
