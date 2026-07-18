<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('events.create') }}" role="button">Tambah Event</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="25%">Judul Event</th>
                        <th scope="col" width="15%">Kategori</th>
                        <th scope="col" width="15%">Venue</th>
                        <th scope="col" width="15%">Tanggal Mulai</th>
                        <th scope="col" width="10%">Status</th>
                        <th scope="col" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $event->title }}</td>
                            <td>{{ $event->category->name ?? '-' }}</td>
                            <td>{{ $event->venue->name ?? '-' }}</td>
                            <td>{{ $event->start_date->format('d M Y H:i') }}</td>
                            <td>
                                @php
                                    $badge = match($event->status) {
                                        'Published'  => 'success',
                                        'Ongoing'    => 'primary',
                                        'Completed'  => 'secondary',
                                        'Cancelled'  => 'danger',
                                        default      => 'warning',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $event->status }}</span>
                            </td>
                            <td>
                                <a href="{{ route('events.edit', $event) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('events.destroy', $event) }}">
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
