<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('organizers.create') }}" role="button">Tambah Organizer</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="20%">Nama Pengguna</th>
                        <th scope="col" width="25%">Nama Perusahaan/Organisasi</th>
                        <th scope="col" width="20%">Email Kontak</th>
                        <th scope="col" width="15%">No. Telepon</th>
                        <th scope="col" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($organizers as $organizer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $organizer->user->name ?? '-' }}</td>
                            <td>{{ $organizer->company_name }}</td>
                            <td>{{ $organizer->contact_email ?? '-' }}</td>
                            <td>{{ $organizer->phone ?? '-' }}</td>
                            <td>
                                <a href="{{ route('organizers.edit', $organizer) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('organizers.destroy', $organizer) }}">
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
