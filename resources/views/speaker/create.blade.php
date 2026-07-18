<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('speakers.store') }}" method="post" enctype="multipart/form-data" class="form">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-md-8">

                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama Lengkap & Gelar</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                            id="name" name="name" required value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="company" class="form-label">Perusahaan / Instansi</label>
                                <input class="form-control @error('company') is-invalid @enderror" type="text"
                                    id="company" name="company" value="{{ old('company') }}">
                                @error('company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact" class="form-label">Kontak (Email/No HP)</label>
                                <input class="form-control @error('contact') is-invalid @enderror" type="text"
                                    id="contact" name="contact" value="{{ old('contact') }}">
                                @error('contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Bio Singkat / Deskripsi</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" id="bio"
                            name="bio" rows="3">{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="events" class="form-label">Pilih Event (Bisa lebih dari satu)</label>
                        <select class="form-select select2-default @error('events') is-invalid @enderror"
                            id="events" name="events[]" multiple="multiple">
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}" {{ (is_array(old('events')) && in_array($event->id, old('events'))) ? 'selected' : '' }}>
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Kosongkan jika belum ada jadwal event.</small>
                        @error('events')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="photo_url" class="form-label">Foto / Avatar</label>
                        <input class="form-control @error('photo_url') is-invalid @enderror" type="file"
                            id="photo_url" name="photo_url" accept="image/*">
                        @error('photo_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="text-end">
                <a href="{{ route('speakers.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

</x-app>
