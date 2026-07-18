<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('feedbacks.store') }}" method="post" class="form">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-md-8 mx-auto">
                    
                    <div class="mb-3">
                        <label for="event_id" class="form-label required">Event yang Diikuti</label>
                        <select class="form-select select2-default @error('event_id') is-invalid @enderror"
                            id="event_id" name="event_id" required>
                            <option value="">-- Pilih Event --</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('event_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="rating" class="form-label required">Penilaian / Rating (1-5)</label>
                        <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                            <option value="5" {{ old('rating', 5) == 5 ? 'selected' : '' }}>5 - Sangat Memuaskan</option>
                            <option value="4" {{ old('rating') == 4 ? 'selected' : '' }}>4 - Memuaskan</option>
                            <option value="3" {{ old('rating') == 3 ? 'selected' : '' }}>3 - Cukup</option>
                            <option value="2" {{ old('rating') == 2 ? 'selected' : '' }}>2 - Kurang</option>
                            <option value="1" {{ old('rating') == 1 ? 'selected' : '' }}>1 - Sangat Kurang</option>
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="comments" class="form-label">Komentar / Saran Tambahan</label>
                        <textarea class="form-control @error('comments') is-invalid @enderror" id="comments"
                            name="comments" rows="4">{{ old('comments') }}</textarea>
                        @error('comments')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-center">
                <a href="{{ route('feedbacks.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Kirim Feedback</button>
            </div>
        </form>
    </div>

</x-app>
