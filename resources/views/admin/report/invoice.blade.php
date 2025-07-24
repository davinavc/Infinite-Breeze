<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{ public_path('img/logo_white.png') }}" type="image/icon type">
    <title>Report Transaction Tenant {{ $tenant->tenant_name }}</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <div class="logo">
        <img src="{{ public_path ('img/LOGO-02.png') }}" alt="Logo">
    </div>

    <h1>Invoice {{ $tenant->tenant_name }} - {{ $event->event_name }}</h1>

    <table class="table-invoice">
        <tr>
            <td class="left-text"><strong>Tenant Name:</strong> {{ $transaksi->tenant->tenant_name }}</td>
            <td class="left-text"><strong>Email:</strong> {{ $transaksi->tenant->user->email }}</td>
        </tr>
        <tr>
            <td class="left-text"><strong>Registered By:</strong> {{ $transaksi->nama_pemesan }}</td>
            <td class="left-text"><strong>No. Telepon:</strong> {{ $transaksi->tenant->user->no_telp }}</td>
        </tr>
    </table>

    <table style="border:1px solid;">
        <thead>
            <tr>
                <th>Transaction Date</th>
                <th>Electricity</th>
                <th>Booth Price</th>
                <th>Additional Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $transaksi->created_at->format('d M Y') }}</td>
                <td>{{ intval($transaksi->watt_listrik) }} Ampere</td>
                <td class="right-text">Rp {{ number_format($transaksi->event->harga, 0, ',', '.') }}</td>
                <td class="right-text">Rp {{ number_format($transaksi->total_price - $transaksi->event->harga, 0, ',', '.') }}</td>
                <td class="right-text">Rp {{ number_format($transaksi->total_price, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    

</body>
</html>
