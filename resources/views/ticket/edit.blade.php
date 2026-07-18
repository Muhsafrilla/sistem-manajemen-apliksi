<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('tickets.update', $ticket) }}" method="post" class="form">
            @csrf
            @method('put')
            <div class="row g-3 mb-3">
                <div class="col-md-12">

                    <div class="mb-3">
                        <label for="event_id" class="form-label required">Event</label>
                        <select class="form-select select2-default @error('event_id') is-invalid @enderror"
                            id="event_id" name="event_id" required>
                            <option value="">-- Pilih Event --</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}"
                                    {{ old('event_id', $ticket->event_id) == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('event_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ticket_type_id" class="form-label required">Jenis Tiket</label>
                        <select class="form-select select2-default @error('ticket_type_id') is-invalid @enderror"
                            id="ticket_type_id" name="ticket_type_id" required>
                            <option value="">-- Pilih Jenis Tiket --</option>
                            @foreach ($ticketTypes as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('ticket_type_id', $ticket->ticket_type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('ticket_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="price" class="form-label required">Harga (Rp)</label>
                                <input class="form-control @error('price') is-invalid @enderror" type="number"
                                    id="price" name="price" required value="{{ old('price', (int)$ticket->price) }}" min="0">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quota" class="form-label required">Kuota / Stok</label>
                                <input class="form-control @error('quota') is-invalid @enderror" type="number"
                                    id="quota" name="quota" required value="{{ old('quota', $ticket->quota) }}" min="1">
                                @error('quota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="benefit" class="form-label">Deskripsi / Benefit</label>
                        <textarea class="form-control @error('benefit') is-invalid @enderror" id="benefit"
                            name="benefit" rows="3">{{ old('benefit', $ticket->benefit) }}</textarea>
                        @error('benefit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check form-switch mt-4">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_active" name="is_active" {{ old('is_active', $ticket->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Tiket Aktif / Bisa Dibeli</label>
                    </div>

                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('tickets.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

</x-app>
