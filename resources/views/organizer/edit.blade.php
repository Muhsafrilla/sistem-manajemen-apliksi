<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('organizers.update', $organizer) }}" method="post" class="form">
            @csrf
            @method('put')
            <div class="row g-3 mb-3">
                <div class="col-md-12">

                    <div class="mb-3">
                        <label for="user_id" class="form-label required">Akun Pengguna (Role: Organizer)</label>
                        <select class="form-select select2-default @error('user_id') is-invalid @enderror"
                            id="user_id" name="user_id" required>
                            <option value="">-- Pilih Pengguna --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('user_id', $organizer->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="company_name" class="form-label required">Nama Perusahaan / Organisasi</label>
                        <input class="form-control @error('company_name') is-invalid @enderror" type="text"
                            id="company_name" name="company_name" required
                            value="{{ old('company_name', $organizer->company_name) }}">
                        @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="contact_email" class="form-label">Email Kontak</label>
                        <input class="form-control @error('contact_email') is-invalid @enderror" type="email"
                            id="contact_email" name="contact_email"
                            value="{{ old('contact_email', $organizer->contact_email) }}">
                        @error('contact_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">No. Telepon</label>
                        <input class="form-control @error('phone') is-invalid @enderror" type="text"
                            id="phone" name="phone" value="{{ old('phone', $organizer->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('organizers.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

</x-app>
