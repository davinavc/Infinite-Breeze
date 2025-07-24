<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{ public_path('img/logo_white.png') }}" type="image/icon type">
    <title>Report Commision Staff {{ $staff->nm_depan }} {{ $staff->nm_blkg }}</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <h1>Report Commision Staff {{ $staff->nm_depan }} {{ $staff->nm_blkg }}</h1>

    <table class="table-invoice">
        <tr>
            <td class="left-text"><strong>Staff Name:</strong> {{ $staff->nm_depan }} {{ $staff->nm_blkg }}</td>
            <td class="left-text"><strong>Email:</strong> {{ $staff->user->email }}</td>
        </tr>
        <tr>
            <td class="left-text"><strong>Department:</strong> {{ $staff->departemen->department }}</td>
            <td class="left-text"><strong>No. Telepon:</strong> {{ $staff->user->no_telp }}</td>
        </tr>
    </table>
    
    <table style="border:1px solid;">
    <thead>
        <tr>
            <th>No</th>
            <th>Transaction Date</th>
            <th>Tenant Name</th>
            <th>Event Name</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($komisiList as $komisiItem)
            @foreach ($komisiItem->transaksi as $transaksi)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $komisiItem->created_at ?? '-' }}</td>
                    <td>{{ $transaksi->tenant->tenant_name ?? '-' }}</td>
                    <td>{{ $transaksi->event->event_name ?? '-' }}</td>
                    <td class="right-text">
                        Rp {{ number_format($transaksi->total_price ?? 0, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        @endforeach

    </tbody>
    </table>

    

</body>
</html>
