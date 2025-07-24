<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{ public_path('img/logo_white.png') }}" type="image/icon type">
    <title>Report Tenant {{ $tenants->tenant_name }}</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <h1>Report Tenant {{ $tenants->tenant_name }}</h1>

    <table class="table-data-event">
            <tr>
                <!-- Gambar -->
                <td class="td-image">
                    <img src="{{ public_path('storage/' . $tenants->logo) }}" alt="Poster" style="max-width: 100%; height: 200px;">
                </td>

                <!-- Teks -->
                <td style="vertical-align: top; padding-left: 20px;text-align:left;">
                    <p><strong>Tenant Name:</strong> {{ $tenants->tenant_name }}</p>
                    <p><strong>Email:</strong> {{ $tenants->user->email }}</p>
                    <p><strong>Phone Number:</strong> {{ $tenants->user->no_telp }}</p>
                    <p><strong>Account Created:</strong> {{ $tenants->created_at->format('d-m-Y') }}</p>
                    <p><strong>Joined Event:</strong> {{ $tenants->joined_event }}</p>
                </td>
            </tr>
        </table>

    <h4>Joined event</h4>
            <table class="table" style="border:1px solid;">
            <thead>
                <tr>
                <th>No</th>
                <th>Nama Event</th>
                <th>Tanggal Event</th>
                <th>Status Pendaftaran</th>
                <th>Status Transaksi</th>
                <th>Total Pembayaran</th>
                <th>Tgl Pendaftaran</th>
                </tr>
            </thead>
            <tbody>
                @php 
                    $no = 1; 
                @endphp
                @foreach($registrations as $index => $reg)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $reg->event->event_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($reg->event->start_date)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($reg->event->finish_date)->format('d-m-Y') }}</td>
                    <td>{{ $reg->status ?? '-' }}</td>
                    @php
                        $trx = $transaksis[$reg->event_id] ?? null;
                    @endphp
                    <td>{{ $trx->status ?? '-' }}</td>
                    <td class="right-text">Rp{{ number_format($trx->total_price ?? 0, 0, ',', '.') }}</td>
                    <td>{{ $reg->created_at->format('d-m-Y') }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>

</body>
</html>
