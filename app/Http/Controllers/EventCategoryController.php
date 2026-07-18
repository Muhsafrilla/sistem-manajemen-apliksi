<?php

namespace App\Http\Controllers;

use App\Models\EventCategory;
use Illuminate\Http\Request;

class EventCategoryController extends Controller
{
    public function index()
    {
        return view('event_category.index', [
            'title' => 'Kategori Event',
            'categories' => EventCategory::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('event_category.create', [
            'title' => 'Tambah Kategori Event',
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255|unique:event_categories,name',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
            'name.unique' => 'Nama kategori sudah ada',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            EventCategory::create($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('event_categories.index')->withSuccess('Kategori berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('event_categories.create')->withError('Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    public function edit(EventCategory $eventCategory)
    {
        return view('event_category.edit', [
            'title' => 'Edit Kategori Event',
            'category' => $eventCategory,
        ]);
    }

    public function update(Request $request, EventCategory $eventCategory)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255|unique:event_categories,name,' . $eventCategory->id,
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
            'name.unique' => 'Nama kategori sudah ada',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $eventCategory->update($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('event_categories.index')->withSuccess('Kategori berhasil diubah');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('event_categories.edit', $eventCategory)->withError('Gagal mengubah kategori: ' . $e->getMessage());
        }
    }

    public function destroy(EventCategory $eventCategory)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $eventCategory->delete();
            \Illuminate\Support\Facades\DB::commit();
            return to_route('event_categories.index')->withSuccess('Kategori berhasil dihapus');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('event_categories.index')->withError('Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}
