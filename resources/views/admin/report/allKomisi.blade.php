<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{ public_path('img/logo_white.png') }}" type="image/icon type">
    <title>Report All Staff Commission</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <h1>
        Report Komisi Semua Staff
        @if($bulan || $tahun)
            @if($bulan) Bulan {{ $bulan }} @endif
            @if($tahun) Tahun {{ $tahun }} @endif

        @else
            Menampilkan semua data komisi
        @endif
    </h1>

    @foreach ($staffs as $staff)
        @if ($komisiList->has($staff->id))
            <table class="table-invoice">
                <tr>
                    <td class="left-text"><strong>Name:</strong> {{ $staff->nm_depan }} {{ $staff->nm_blkg }}</td>
                    <td class="left-text"><strong>Department:</strong> {{ $staff->departemen->department ?? '-' }}</td>
                    <td class="left-text"><strong>Status:</strong> {{ $staff->status }}</td>
                </tr>
                <tr>
                    <td class="left-text"><strong>Email:</strong> {{ $staff->user->email ?? '-' }}</td>
                    <td class="left-text"><strong>Telepon:</strong> {{ $staff->user->no_telp ?? '-' }}</td>
                    <td class="left-text"><strong>Total Referral Usage:</strong> {{ $referral_usage[$staff->id] ?? '-' }}</td>
                </tr>
            </table>

            <table style="border:1px solid; width: 100%; margin-bottom: 30px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Transaksi</th>
                        <th>Tenant</th>
                        <th>Event</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @foreach ($komisiList[$staff->id] as $komisi)
                       @foreach ($komisi->transaksi as $transaksi)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $transaksi->created_at->format('d-m-Y') ?? '-' }}</td>
                                <td>{{ $transaksi->tenant->tenant_name ?? '-' }}</td>
                                <td>{{ $transaksi->event->event_name ?? '-' }}</td>
                                <td>Rp {{ number_format($transaksi->total_price ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        @endif
    @endforeach
</body>
</html>