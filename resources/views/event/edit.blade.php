<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('events.update', $event) }}" method="post" enctype="multipart/form-data" class="form">
            @csrf
            @method('put')
            <div class="row g-3 mb-3">

                <div class="col-md-8">
                    <div class="mb-3">
                        <label for="title" class="form-label required">Judul Event</label>
                        <input class="form-control @error('title') is-invalid @enderror" type="text"
                            id="title" name="title" required value="{{ old('title', $event->title) }}">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description" rows="4">{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label required">Tanggal Mulai</label>
                                <input class="form-control @error('start_date') is-invalid @enderror"
                                    type="datetime-local" id="start_date" name="start_date"
                                    required value="{{ old('start_date', $event->start_date?->format('Y-m-d\TH:i')) }}">
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label required">Tanggal Selesai</label>
                                <input class="form-control @error('end_date') is-invalid @enderror"
                                    type="datetime-local" id="end_date" name="end_date"
                                    required value="{{ old('end_date', $event->end_date?->format('Y-m-d\TH:i')) }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="organizer_id" class="form-label required">Organizer</label>
                        <select class="form-select select2-default @error('organizer_id') is-invalid @enderror"
                            id="organizer_id" name="organizer_id" required>
                            <option value="">-- Pilih Organizer --</option>
                            @foreach ($organizers as $organizer)
                                <option value="{{ $organizer->id }}"
                                    {{ old('organizer_id', $event->organizer_id) == $organizer->id ? 'selected' : '' }}>
                                    {{ $organizer->company_name }} ({{ $organizer->user->name ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        @error('organizer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label required">Kategori</label>
                        <select class="form-select select2-default @error('category_id') is-invalid @enderror"
                            id="category_id" name="category_id" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $event->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="venue_id" class="form-label required">Venue / Lokasi</label>
                        <select class="form-select select2-default @error('venue_id') is-invalid @enderror"
                            id="venue_id" name="venue_id" required>
                            <option value="">-- Pilih Venue --</option>
                            @foreach ($venues as $venue)
                                <option value="{{ $venue->id }}"
                                    {{ old('venue_id', $event->venue_id) == $venue->id ? 'selected' : '' }}>
                                    {{ $venue->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('venue_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label required">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror"
                            id="status" name="status" required>
                            @foreach(['Draft', 'Published', 'Ongoing', 'Completed', 'Cancelled'] as $s)
                                <option value="{{ $s }}"
                                    {{ old('status', $event->status) == $s ? 'selected' : '' }}>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="poster" class="form-label">Poster (Opsional)</label>
                        @if ($event->poster)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster"
                                    class="img-thumbnail" style="max-height: 120px;">
                            </div>
                        @endif
                        <input class="form-control @error('poster') is-invalid @enderror" type="file"
                            id="poster" name="poster" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah poster.</small>
                        @error('poster')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="text-end">
                <a href="{{ route('events.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

</x-app>
