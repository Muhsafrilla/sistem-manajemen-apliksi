<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\FeedbackForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackFormController extends Controller
{
    public function index()
    {
        $feedbacks = FeedbackForm::with(['event', 'user'])->latest()->get();
        return view('feedback.index', [
            'title'     => 'Feedback Peserta',
            'feedbacks' => $feedbacks,
        ]);
    }

    public function create()
    {
        return view('feedback.create', [
            'title'  => 'Isi Feedback',
            'events' => Event::orderBy('title')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'event_id' => 'required|exists:events,id',
            'rating'   => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string',
        ]);

        $validate['user_id'] = Auth::id() ?? 1; // Fallback jika tidak login

        FeedbackForm::create($validate);

        return to_route('feedbacks.index')->withSuccess('Terima kasih! Feedback Anda telah disimpan.');
    }

    public function edit(FeedbackForm $feedback)
    {
        return view('feedback.edit', [
            'title'    => 'Edit Feedback',
            'feedback' => $feedback,
            'events'   => Event::orderBy('title')->get(),
        ]);
    }

    public function update(Request $request, FeedbackForm $feedback)
    {
        $validate = $request->validate([
            'event_id' => 'required|exists:events,id',
            'rating'   => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string',
        ]);

        $feedback->update($validate);

        return to_route('feedbacks.index')->withSuccess('Feedback berhasil diperbarui.');
    }

    public function destroy(FeedbackForm $feedback)
    {
        $feedback->delete();
        return to_route('feedbacks.index')->withSuccess('Feedback berhasil dihapus.');
    }
}
