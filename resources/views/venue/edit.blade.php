<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('venues.update', $venue) }}" method="post" class="form">
            @csrf
            @method('put')
            <div class="row g-3 mb-3">
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama Venue</label>
                        <input class="form-control @error('name') is-invalid  @enderror" type="text" id="name"
                            name="name" required value="{{ old('name', $venue->name) }}">
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="capacity" class="form-label required">Kapasitas</label>
                        <input class="form-control @error('capacity') is-invalid  @enderror" type="number" id="capacity"
                            name="capacity" required value="{{ old('capacity', $venue->capacity) }}" min="1">
                        @error('capacity')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid  @enderror" id="address"
                            name="address" rows="3">{{ old('address', $venue->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('venues.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

</x-app>
