<x-app>

    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="card shadow-lg p-3">

        <h5 class="mb-4 text-center">Laporan Analitik Kehadiran & Feedback Event</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped w-100" id="data-table">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" width="5%" class="text-center">#</th>
                        <th scope="col" width="25%">Nama Event</th>
                        <th scope="col" width="15%" class="text-center">Total Terdaftar (Confirmed)</th>
                        <th scope="col" width="15%" class="text-center">Peserta Hadir (Check-In)</th>
                        <th scope="col" width="15%" class="text-center">Tidak Hadir (No-Show)</th>
                        <th scope="col" width="15%" class="text-center">Persentase Kehadiran</th>
                        <th scope="col" width="10%" class="text-center">Rata-rata Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event)
                        @php
                            $attendanceRate = $event->confirmed > 0 ? round(($event->attended / $event->confirmed) * 100, 1) : 0;
                        @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $event->title }}</td>
                            <td class="text-center fs-5 text-primary fw-bold">{{ $event->confirmed }}</td>
                            <td class="text-center fs-5 text-success fw-bold">{{ $event->attended }}</td>
                            <td class="text-center fs-5 text-danger fw-bold">{{ $event->not_attended }}</td>
                            <td class="text-center align-middle">
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $attendanceRate }}%;" aria-valuenow="{{ $attendanceRate }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $attendanceRate }}%
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning text-dark fs-6">
                                    <i class="bx bxs-star"></i> {{ number_format($event->avg_rating, 1) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

</x-app>
