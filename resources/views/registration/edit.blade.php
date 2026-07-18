<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('registrations.update', $registration) }}" method="post" class="form">
            @csrf
            @method('put')
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <h5 class="mb-3 border-bottom pb-2">Data Event & Tiket</h5>
                    
                    <div class="mb-3">
                        <label class="form-label">Event</label>
                        <input class="form-control" type="text" value="{{ $registration->event->title ?? '-' }}" disabled>
                        <small class="text-muted">Event tidak dapat diubah setelah registrasi dibuat.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tiket Terpilih</label>
                        @php
                            $ticketName = $registration->ticket->ticketType->name ?? 'Tiket';
                            $ticketPrice = 'Rp ' . number_format($registration->ticket->price ?? 0, 0, ',', '.');
                        @endphp
                        <input class="form-control" type="text" value="{{ $ticketName }} - {{ $ticketPrice }}" disabled>
                        <small class="text-muted">Sisa kuota tiket saat ini: {{ $registration->ticket->quota ?? 0 }}</small>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label required">Status Registrasi</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Pending" {{ old('status', $registration->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Confirmed" {{ old('status', $registration->status) == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="Cancelled" {{ old('status', $registration->status) == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <small class="text-muted">Mengubah ke Confirmed akan mengurangi kuota tiket. Cancelled akan mengembalikan kuota.</small>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_attended" name="is_attended" {{ old('is_attended', $registration->is_attended) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_attended">Peserta Telah Hadir (Check-In)</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="mb-3 border-bottom pb-2">Data Peserta</h5>

                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama Lengkap</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                            id="name" name="name" required value="{{ old('name', $registration->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label required">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                            id="email" name="email" required value="{{ old('email', $registration->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label required">No HP / WhatsApp</label>
                        <input class="form-control @error('phone') is-invalid @enderror" type="text"
                            id="phone" name="phone" required value="{{ old('phone', $registration->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('registrations.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>

</x-app>
