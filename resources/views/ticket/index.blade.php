<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('tickets.create') }}" role="button">Tambah Tiket</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="25%">Nama Event</th>
                        <th scope="col" width="15%">Jenis Tiket</th>
                        <th scope="col" width="15%">Harga</th>
                        <th scope="col" width="10%">Kuota</th>
                        <th scope="col" width="10%">Status</th>
                        <th scope="col" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $ticket->event->title ?? '-' }}</td>
                            <td>{{ $ticket->ticketType->name ?? '-' }}</td>
                            <td>Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
                            <td>{{ number_format($ticket->quota, 0, ',', '.') }}</td>
                            <td>
                                @if($ticket->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-danger">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('tickets.destroy', $ticket) }}">
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
