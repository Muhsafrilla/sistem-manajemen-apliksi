<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('sponsors.create') }}" role="button">Tambah Sponsor</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="10%">Logo</th>
                        <th scope="col" width="20%">Nama Sponsor</th>
                        <th scope="col" width="15%">Level / Tier</th>
                        <th scope="col" width="20%">Event Terkait</th>
                        <th scope="col" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sponsors as $sponsor)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if($sponsor->logo_url)
                                    <img src="{{ asset('storage/' . $sponsor->logo_url) }}" alt="Logo" width="60">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($sponsor->name) }}" alt="Logo" width="50" class="rounded">
                                @endif
                            </td>
                            <td>{{ $sponsor->name }}</td>
                            <td>
                                @php
                                    $badge = match(strtolower($sponsor->tier)) {
                                        'platinum' => 'dark',
                                        'gold'     => 'warning',
                                        'silver'   => 'secondary',
                                        'bronze'   => 'danger',
                                        default    => 'primary',
                                    };
                                @endphp
                                <span class="badge bg-{{ $badge }}">{{ $sponsor->tier }}</span>
                            </td>
                            <td>
                                @foreach($sponsor->events as $event)
                                    <span class="badge bg-info mb-1">{{ $event->title }}</span><br>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('sponsors.edit', $sponsor) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('sponsors.destroy', $sponsor) }}">
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
