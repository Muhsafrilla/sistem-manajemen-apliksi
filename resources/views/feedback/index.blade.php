<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <div class="mb-3">
            <a class="btn btn-primary" href="{{ route('feedbacks.create') }}" role="button">Isi Feedback</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead>
                    <tr>
                        <th scope="col" width="5%">#</th>
                        <th scope="col" width="15%">Tanggal</th>
                        <th scope="col" width="20%">Peserta</th>
                        <th scope="col" width="20%">Event</th>
                        <th scope="col" width="10%">Rating</th>
                        <th scope="col" width="20%">Komentar</th>
                        <th scope="col" width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feedbacks as $fb)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $fb->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $fb->user->name ?? 'Guest' }}</td>
                            <td>{{ $fb->event->title ?? '-' }}</td>
                            <td>
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $fb->rating)
                                        <i class="bx bxs-star text-warning"></i>
                                    @else
                                        <i class="bx bx-star text-secondary"></i>
                                    @endif
                                @endfor
                            </td>
                            <td>{{ Str::limit($fb->comments, 50) }}</td>
                            <td>
                                <a href="{{ route('feedbacks.edit', $fb) }}" class="btn btn-warning btn-sm">
                                    <i class='bx bx-edit-alt'></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal" data-route="{{ route('feedbacks.destroy', $fb) }}">
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
