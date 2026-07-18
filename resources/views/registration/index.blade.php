<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('registrations.create') }}" role="button">Buat Registrasi Baru</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="15%">Tanggal</th>
                        <th scope="col" width="20%">Nama Peserta</th>
                        <th scope="col" width="20%">Event</th>
                        <th scope="col" width="15%">Tiket (Harga)</th>
                        <th scope="col" width="10%">Status</th>
                        <th scope="col" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registrations as $reg)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $reg->registered_at->format('d M Y H:i') }}</td>
                            <td>
                                {{ $reg->name }}<br>
                                <small class="text-muted">{{ $reg->email }}</small>
                            </td>
                            <td>{{ $reg->event->title ?? '-' }}</td>
                            <td>
                                {{ $reg->ticket->ticketType->name ?? '-' }}<br>
                                <small class="text-muted">Rp {{ number_format($reg->ticket->price ?? 0, 0, ',', '.') }}</small>
                            </td>
                            <td>
                                @php
                                    $badge = match($reg->status) {
                                        'Confirmed' => 'success',
                                        'Pending'   => 'warning',
                                        'Cancelled' => 'danger',
                                        default     => 'secondary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $reg->status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('registrations.edit', $reg) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('registrations.destroy', $reg) }}">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    @push('scripts')
        <script>
            $('#data-table').on('click', '.btn-delete', function() {
                $('#form-delete').attr('action', $(this).data('route'))
            })
        </script>
    @endpush

</x-app>
