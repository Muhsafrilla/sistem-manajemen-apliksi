<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Organizer;
use App\Models\Venue;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('event.index', [
            'title'  => 'Manajemen Event',
            'events' => Event::with(['category', 'venue', 'organizer'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('event.create', [
            'title'      => 'Tambah Event',
            'categories' => EventCategory::orderBy('name')->get(),
            'venues'     => Venue::orderBy('name')->get(),
            'organizers' => Organizer::with('user')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'organizer_id' => 'required|exists:organizers,id',
            'category_id'  => 'required|exists:event_categories,id',
            'venue_id'     => 'required|exists:venues,id',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'status'       => 'required|in:Draft,Published,Ongoing,Completed,Cancelled',
            'poster'       => 'nullable|image|max:2048',
        ], [
            'title.required'        => 'Judul event wajib diisi',
            'organizer_id.required' => 'Organizer wajib dipilih',
            'category_id.required'  => 'Kategori wajib dipilih',
            'venue_id.required'     => 'Venue wajib dipilih',
            'start_date.required'   => 'Tanggal mulai wajib diisi',
            'end_date.required'     => 'Tanggal selesai wajib diisi',
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh kurang dari tanggal mulai',
            'status.required'       => 'Status wajib dipilih',
            'poster.image'          => 'File poster harus berupa gambar',
            'poster.max'            => 'Ukuran poster maksimal 2MB',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            if ($request->hasFile('poster')) {
                $validate['poster'] = $request->file('poster')->store('posters', 'public');
            }

            Event::create($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('events.index')->withSuccess('Event berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('events.create')->withError('Gagal menambahkan event: ' . $e->getMessage());
        }
    }

    public function edit(Event $event)
    {
        return view('event.edit', [
            'title'      => 'Edit Event',
            'event'      => $event,
            'categories' => EventCategory::orderBy('name')->get(),
            'venues'     => Venue::orderBy('name')->get(),
            'organizers' => Organizer::with('user')->get(),
        ]);
    }

    public function update(Request $request, Event $event)
    {
        $validate = $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'organizer_id' => 'required|exists:organizers,id',
            'category_id'  => 'required|exists:event_categories,id',
            'venue_id'     => 'required|exists:venues,id',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'status'       => 'required|in:Draft,Published,Ongoing,Completed,Cancelled',
            'poster'       => 'nullable|image|max:2048',
        ], [
            'title.required'        => 'Judul event wajib diisi',
            'organizer_id.required' => 'Organizer wajib dipilih',
            'category_id.required'  => 'Kategori wajib dipilih',
            'venue_id.required'     => 'Venue wajib dipilih',
            'start_date.required'   => 'Tanggal mulai wajib diisi',
            'end_date.required'     => 'Tanggal selesai wajib diisi',
            'end_date.after_or_equal' => 'Tanggal selesai tidak boleh kurang dari tanggal mulai',
            'status.required'       => 'Status wajib dipilih',
            'poster.image'          => 'File poster harus berupa gambar',
            'poster.max'            => 'Ukuran poster maksimal 2MB',
        ]);

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            if ($request->hasFile('poster')) {
                if ($event->poster) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($event->poster);
                }
                $validate['poster'] = $request->file('poster')->store('posters', 'public');
            }

            $event->update($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('events.index')->withSuccess('Event berhasil diubah');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('events.edit', $event)->withError('Gagal mengubah event: ' . $e->getMessage());
        }
    }

    public function destroy(Event $event)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            if ($event->poster) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($event->poster);
            }
            $event->delete();
            \Illuminate\Support\Facades\DB::commit();
            return to_route('events.index')->withSuccess('Event berhasil dihapus');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('events.index')->withError('Gagal menghapus event: ' . $e->getMessage());
        }
    }
}
