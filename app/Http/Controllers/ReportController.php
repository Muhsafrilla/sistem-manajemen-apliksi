<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Rekap kehadiran dan feedback per event
        $events = Event::withCount('registrations')
            ->with(['registrations' => function ($query) {
                $query->where('status', 'Confirmed');
            }])
            ->withAvg('feedbackForms', 'rating')
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($event) {
                $confirmed = $event->registrations->count();
                $attended = $event->registrations->where('is_attended', true)->count();
                $notAttended = $confirmed - $attended;

                return (object)[
                    'id'                   => $event->id,
                    'title'                => $event->title,
                    'total_registrations'  => $event->registrations_count,
                    'confirmed'            => $confirmed,
                    'attended'             => $attended,
                    'not_attended'         => $notAttended,
                    'avg_rating'           => $event->feedback_forms_avg_rating ?? 0,
                ];
            });

        return view('report.index', [
            'title'  => 'Laporan Kehadiran & Feedback',
            'events' => $events,
        ]);
    }
}
