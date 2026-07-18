<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('sponsors.update', $sponsor) }}" method="post" enctype="multipart/form-data" class="form">
            @csrf
            @method('put')
            <div class="row g-3 mb-3">
                <div class="col-md-8">

                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama Sponsor / Perusahaan</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                            id="name" name="name" required value="{{ old('name', $sponsor->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tier" class="form-label required">Level / Tier Sponsorship</label>
                                <select class="form-select @error('tier') is-invalid @enderror" id="tier" name="tier" required>
                                    <option value="Platinum" {{ old('tier', $sponsor->tier) == 'Platinum' ? 'selected' : '' }}>Platinum</option>
                                    <option value="Gold" {{ old('tier', $sponsor->tier) == 'Gold' ? 'selected' : '' }}>Gold</option>
                                    <option value="Silver" {{ old('tier', $sponsor->tier) == 'Silver' ? 'selected' : '' }}>Silver</option>
                                    <option value="Bronze" {{ old('tier', $sponsor->tier) == 'Bronze' ? 'selected' : '' }}>Bronze</option>
                                </select>
                                @error('tier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="contact" class="form-label">Kontak (Email/No HP)</label>
                                <input class="form-control @error('contact') is-invalid @enderror" type="text"
                                    id="contact" name="contact" value="{{ old('contact', $sponsor->contact) }}">
                                @error('contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="events" class="form-label">Pilih Event (Bisa lebih dari satu)</label>
                        <select class="form-select select2-default @error('events') is-invalid @enderror"
                            id="events" name="events[]" multiple="multiple">
                            @php
                                $selectedEvents = old('events', $sponsor->events->pluck('id')->toArray());
                            @endphp
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}" {{ in_array($event->id, $selectedEvents) ? 'selected' : '' }}>
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Kosongkan jika belum terafiliasi dengan event.</small>
                        @error('events')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="logo_url" class="form-label">Logo Sponsor</label>
                        @if ($sponsor->logo_url)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $sponsor->logo_url) }}" alt="Logo"
                                    class="img-thumbnail" style="max-height: 120px;">
                            </div>
                        @endif
                        <input class="form-control @error('logo_url') is-invalid @enderror" type="file"
                            id="logo_url" name="logo_url" accept="image/*">
                        @error('logo_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="text-end">
                <a href="{{ route('sponsors.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

</x-app>
