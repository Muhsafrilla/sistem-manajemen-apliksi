<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\TicketType;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        return view('ticket.index', [
            'title'   => 'Manajemen Tiket',
            'tickets' => Ticket::with(['event', 'ticketType'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('ticket.create', [
            'title'       => 'Tambah Tiket',
            'events'      => Event::orderBy('title')->get(),
            'ticketTypes' => TicketType::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'event_id'       => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'price'          => 'required|numeric|min:0',
            'quota'          => 'required|integer|min:1',
            'benefit'        => 'nullable|string',
            'is_active'      => 'boolean',
        ], [
            'event_id.required'       => 'Event wajib dipilih',
            'ticket_type_id.required' => 'Jenis tiket wajib dipilih',
            'price.required'          => 'Harga wajib diisi',
            'price.numeric'           => 'Harga harus berupa angka',
            'price.min'               => 'Harga minimal Rp 0',
            'quota.required'          => 'Kuota wajib diisi',
            'quota.integer'           => 'Kuota harus berupa bilangan bulat',
            'quota.min'               => 'Kuota minimal 1',
        ]);

        $validate['is_active'] = $request->has('is_active');

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            Ticket::create($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('tickets.index')->withSuccess('Tiket berhasil ditambahkan');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('tickets.create')->withError('Gagal menambahkan tiket: ' . $e->getMessage());
        }
    }

    public function edit(Ticket $ticket)
    {
        return view('ticket.edit', [
            'title'       => 'Edit Tiket',
            'ticket'      => $ticket,
            'events'      => Event::orderBy('title')->get(),
            'ticketTypes' => TicketType::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validate = $request->validate([
            'event_id'       => 'required|exists:events,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'price'          => 'required|numeric|min:0',
            'quota'          => 'required|integer|min:1',
            'benefit'        => 'nullable|string',
            'is_active'      => 'boolean',
        ], [
            'event_id.required'       => 'Event wajib dipilih',
            'ticket_type_id.required' => 'Jenis tiket wajib dipilih',
            'price.required'          => 'Harga wajib diisi',
            'price.numeric'           => 'Harga harus berupa angka',
            'price.min'               => 'Harga minimal Rp 0',
            'quota.required'          => 'Kuota wajib diisi',
            'quota.integer'           => 'Kuota harus berupa bilangan bulat',
            'quota.min'               => 'Kuota minimal 1',
        ]);

        $validate['is_active'] = $request->has('is_active');

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $ticket->update($validate);
            \Illuminate\Support\Facades\DB::commit();
            return to_route('tickets.index')->withSuccess('Tiket berhasil diubah');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('tickets.edit', $ticket)->withError('Gagal mengubah tiket: ' . $e->getMessage());
        }
    }

    public function destroy(Ticket $ticket)
    {
        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            $ticket->delete();
            \Illuminate\Support\Facades\DB::commit();
            return to_route('tickets.index')->withSuccess('Tiket berhasil dihapus');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return to_route('tickets.index')->withError('Gagal menghapus tiket: ' . $e->getMessage());
        }
    }
}
