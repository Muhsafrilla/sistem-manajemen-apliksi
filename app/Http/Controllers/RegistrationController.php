<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('registration.index', [
            'title'         => 'Data Registrasi',
            'registrations' => Registration::with(['event', 'ticket.ticketType', 'user'])->latest()->get(),
        ]);
    }

    public function create()
    {
        return view('registration.create', [
            'title'  => 'Registrasi Event',
            'events' => Event::where('status', 'Published')->orderBy('title')->get(),
            // tickets akan di-load via JS saat event dipilih, atau bisa dikirim semua sebagai data json
            'tickets' => Ticket::with('ticketType')->where('is_active', true)->where('quota', '>', 0)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'event_id'  => 'required|exists:events,id',
            'ticket_id' => 'required|exists:tickets,id',
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'required|string|max:255',
            'status'    => 'required|in:Pending,Confirmed,Cancelled',
        ], [
            'event_id.required'  => 'Event wajib dipilih',
            'ticket_id.required' => 'Tiket wajib dipilih',
            'name.required'      => 'Nama wajib diisi',
            'email.required'     => 'Email wajib diisi',
            'phone.required'     => 'No HP wajib diisi',
        ]);

        DB::beginTransaction();

        try {
            $ticket = Ticket::find($validate['ticket_id']);
            
            if ($ticket->event_id != $validate['event_id']) {
                throw new \Exception('Tiket tidak sesuai dengan event yang dipilih.');
            }

            if ($ticket->quota < 1) {
                throw new \Exception('Maaf, kuota tiket sudah habis.');
            }

            $validate['registered_at'] = now();
            
            // jika status Confirmed, kurangi kuota
            if ($validate['status'] == 'Confirmed') {
                $ticket->decrement('quota');
            }

            Registration::create($validate);

            DB::commit();
            return to_route('registrations.index')->withSuccess('Registrasi berhasil dibuat');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('registrations.create')->withError('Gagal melakukan registrasi: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Registration $registration)
    {
        return view('registration.edit', [
            'title'        => 'Edit Registrasi',
            'registration' => $registration,
            'events'       => Event::orderBy('title')->get(),
            'tickets'      => Ticket::with('ticketType')->where('event_id', $registration->event_id)->get(),
        ]);
    }

    public function update(Request $request, Registration $registration)
    {
        $validate = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'required|string|max:255',
            'status'    => 'required|in:Pending,Confirmed,Cancelled',
        ]);

        DB::beginTransaction();

        try {
            // Cek perubahan status untuk mengatur kuota tiket
            if ($registration->status != 'Confirmed' && $validate['status'] == 'Confirmed') {
                $ticket = Ticket::find($registration->ticket_id);
                if ($ticket->quota < 1) {
                    throw new \Exception('Maaf, kuota tiket sudah habis untuk konfirmasi.');
                }
                $ticket->decrement('quota');
            } elseif ($registration->status == 'Confirmed' && $validate['status'] != 'Confirmed') {
                $ticket = Ticket::find($registration->ticket_id);
                $ticket->increment('quota');
            }

            $registration->update($validate);

            DB::commit();
            return to_route('registrations.index')->withSuccess('Registrasi berhasil diubah');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('registrations.edit', $registration)->withError('Gagal mengubah registrasi: ' . $e->getMessage());
        }
    }

    public function destroy(Registration $registration)
    {
        DB::beginTransaction();

        try {
            // Kembalikan kuota jika status confirmed
            if ($registration->status == 'Confirmed') {
                $ticket = Ticket::find($registration->ticket_id);
                if ($ticket) {
                    $ticket->increment('quota');
                }
            }
            $registration->delete();
            DB::commit();
            return to_route('registrations.index')->withSuccess('Registrasi berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            return to_route('registrations.index')->withError('Gagal menghapus registrasi: ' . $e->getMessage());
        }
    }
}
