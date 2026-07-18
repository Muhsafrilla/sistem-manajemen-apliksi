<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">
        <form action="{{ route('registrations.store') }}" method="post" class="form">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <h5 class="mb-3 border-bottom pb-2">Data Event & Tiket</h5>
                    
                    <div class="mb-3">
                        <label for="event_id" class="form-label required">Pilih Event</label>
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
                        <label for="ticket_id" class="form-label required">Pilih Tiket</label>
                        <select class="form-select @error('ticket_id') is-invalid @enderror"
                            id="ticket_id" name="ticket_id" required>
                            <option value="">-- Pilih Event Terlebih Dahulu --</option>
                        </select>
                        <small class="text-muted" id="ticket_info">Hanya menampilkan tiket yang berstatus aktif dan kuota > 0.</small>
                        @error('ticket_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label required">Status Registrasi</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Confirmed" {{ old('status', 'Confirmed') == 'Confirmed' ? 'selected' : '' }}>Confirmed (Potong Kuota)</option>
                            <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="mb-3 border-bottom pb-2">Data Peserta</h5>

                    <div class="mb-3">
                        <label for="name" class="form-label required">Nama Lengkap</label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text"
                            id="name" name="name" required value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label required">Email</label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email"
                            id="email" name="email" required value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label required">No HP / WhatsApp</label>
                        <input class="form-control @error('phone') is-invalid @enderror" type="text"
                            id="phone" name="phone" required value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="text-end">
                <a href="{{ route('registrations.index') }}" class="btn btn-warning me-1">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Registrasi</button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                var allTickets = @json($tickets);
                var oldTicketId = "{{ old('ticket_id') }}";

                function updateTicketOptions() {
                    var eventId = $('#event_id').val();
                    var ticketSelect = $('#ticket_id');
                    ticketSelect.empty();
                    
                    if (!eventId) {
                        ticketSelect.append('<option value="">-- Pilih Event Terlebih Dahulu --</option>');
                        return;
                    }

                    ticketSelect.append('<option value="">-- Pilih Tiket --</option>');
                    var filtered = allTickets.filter(function(t) {
                        return t.event_id == eventId;
                    });

                    if (filtered.length === 0) {
                        ticketSelect.empty().append('<option value="">-- Tidak ada tiket tersedia --</option>');
                    } else {
                        filtered.forEach(function(t) {
                            var price = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(t.price);
                            var selected = (oldTicketId == t.id) ? 'selected' : '';
                            var optionText = (t.ticket_type ? t.ticket_type.name : 'Tiket') + ' - ' + price + ' (Sisa: ' + t.quota + ')';
                            ticketSelect.append('<option value="'+t.id+'" '+selected+'>'+optionText+'</option>');
                        });
                    }
                }

                $('#event_id').on('change', updateTicketOptions);
                
                // Trigger on load for old inputs
                if($('#event_id').val()) {
                    updateTicketOptions();
                }
            });
        </script>
    @endpush

</x-app>
