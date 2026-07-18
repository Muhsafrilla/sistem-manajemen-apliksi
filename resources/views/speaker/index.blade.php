<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('speakers.create') }}" role="button">Tambah Pembicara</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="10%">Foto</th>
                        <th scope="col" width="20%">Nama</th>
                        <th scope="col" width="15%">Instansi/Perusahaan</th>
                        <th scope="col" width="20%">Event Terkait</th>
                        <th scope="col" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($speakers as $speaker)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($speaker->photo_url)
                                    <img src="{{ asset('storage/' . $speaker->photo_url) }}" alt="Foto" width="50" class="rounded-circle">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($speaker->name) }}" alt="Foto" width="50" class="rounded-circle">
                                @endif
                            </td>
                            <td>{{ $speaker->name }}</td>
                            <td>{{ $speaker->company ?? '-' }}</td>
                            <td>
                                @foreach($speaker->events as $event)
                                    <span class="badge bg-info mb-1">{{ $event->title }}</span><br>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('speakers.edit', $speaker) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('speakers.destroy', $speaker) }}">
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
