<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{ public_path('img/logo_white.png') }}" type="image/icon type">
    <title>Report Event {{ $event->event_name }}</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <h1>Report Event {{ $event->event_name }}</h1>
    <table class="table-data-event">
        <tr>
            <!-- Gambar -->
            <td class="td-image">
                <img src="{{ public_path('storage/' . $event->poster) }}" alt="Poster" style="max-width: 100%; height: auto;">
            </td>

            <!-- Teks -->
            <td class="event-data">
                <p><strong>Name:</strong> {{ $event->event_name }}</p>
                <p><strong>Date:</strong> {{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') : ' - ' }} - {{ $event->finish_date ? \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : ' - ' }}</p>
                <p><strong>Place:</strong> {{ $event->place }}</p>
                <p><strong>Theme:</strong> {{ $event->theme }}</p>
                <p><strong>Technical Meeting Date:</strong> {{ $event->tm }}</p>
                <p><strong>Technical Meeting Place/Link:</strong> {{ $event->tm_link }}</p>
                <p><strong>Tenant:</strong> {{ $event->tenant_quota }}</p>
                <p><strong>Electricity Support:</strong> {{ $event->supported_electricity }}</p>
                <p><strong>Additional Electricity Price:</strong> Rp {{ number_format($event->price_per_watt, 0, ',', '.') }}</p>
                <p><strong>Booth Price:</strong> Rp {{ number_format($event->harga, 0, ',', '.') }}</p>
                <p><strong>Capital:</strong> Rp {{ number_format($event->capital, 0, ',', '.') }}</p>
                <p><strong>Revenue:</strong> Rp {{ number_format($event->revenue, 0, ',', '.') }}</p>
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
            @foreach ($event->transactions->where('status', 'Successful') as $transaction)
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
            @foreach ($event->jadwalStaff->sortBy('tgl_event') as $jadwal)
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

    

</body>
</html>