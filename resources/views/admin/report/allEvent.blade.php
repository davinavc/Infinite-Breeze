<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{ public_path('img/logo_white.png') }}" type="image/icon type">
    <title>Report Semua Event</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <h1>Report Semua Event Bulan {{ $bulan }} Tahun {{ $tahun }}</h1>
    @foreach ($event as $e)
        <hr>
        <h2>{{ $e->event_name }}</h2>
        <table class="table-data-event">
            <tr>
                <td class="td-image">
                    <img src="{{ public_path('storage/' . $e->poster) }}" alt="Poster" style="max-width: 100%; height: auto;">
                </td>
                <td class="event-data">
                    <p><strong>Name:</strong> {{ $e->event_name }}</p>
                    <p><strong>Date:</strong> {{ $e->start_date ? \Carbon\Carbon::parse($e->start_date)->format('d-m-Y') : ' - ' }} - {{ $e->finish_date ? \Carbon\Carbon::parse($e->finish_date)->format('d-m-Y') : ' - ' }}</p>
                    <p><strong>Place:</strong> {{ $e->place }}</p>
                    <p><strong>Theme:</strong> {{ $e->theme }}</p>
                    <p><strong>Technical Meeting Date:</strong> {{ $e->tm }}</p>
                    <p><strong>Technical Meeting Place/Link:</strong> {{ $e->tm_link }}</p>
                    <p><strong>Tenant:</strong> {{ $e->tenant_quota }}</p>
                    <p><strong>Electricity Support:</strong> {{ $e->supported_electricity }}</p>
                    <p><strong>Additional Electricity Price:</strong> Rp {{ number_format($e->price_per_watt, 0, ',', '.') }}</p>
                    <p><strong>Booth Price:</strong> Rp {{ number_format($e->harga, 0, ',', '.') }}</p>
                    <p><strong>Capital:</strong> Rp {{ number_format($e->capital, 0, ',', '.') }}</p>
                    <p><strong>Revenue:</strong> Rp {{ number_format($e->revenue, 0, ',', '.') }}</p>
                </td>
            </tr>
        </table>
        <h2>List Tenant</h2>
        <table style="border: 1px solid;">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tenant</th>
                    <th>Email</th>
                    <th>Nomor Telepon</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @foreach ($e->transactions->where('status', 'Successful') as $transaction)
                <tr style="border: 1px solid;">
                    <td>{{ $no++ }}</td>
                    <td>{{ $transaction->tenant->tenant_name }}</td>
                    <td>{{ $transaction->tenant->user->email }}</td>
                    <td>{{ $transaction->tenant->user->no_telp }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    <h2>List Staff</h2>
    <table style="border:1px solid;">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Event</th>
                <th>Nama Staff</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($e->jadwalStaff->sortBy('tgl_event') as $jadwal)
                @php
                    $confirmedStaffs = $jadwal->registrasi->where('status', 'Confirmed')->map(function($regis) {
                        return $regis->staff->nm_depan ?? '-';
                    })->implode(', ');
                @endphp
                @if ($confirmedStaffs != '')
                    <tr style="border: 1px solid;">
                        <td>{{ $no++ }}</td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tgl_event)->format('d-m-Y') }}</td>
                        <td>{{ $confirmedStaffs }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
    @endforeach
</body>
</html>
