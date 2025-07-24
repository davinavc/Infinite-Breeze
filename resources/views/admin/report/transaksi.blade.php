<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{ public_path('img/logo_white.png') }}" type="image/icon type">
    <title>Report Transaction Event {{ $event->event_name }}</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <h1>Report Transaction Event {{ $event->event_name }}</h1>
    <table class="table-data-event">
        <tr>
            <!-- Gambar -->
            <td class="td-image">
                <img src="{{ public_path('storage/' . $event->poster) }}" alt="Poster" style="max-width: 100%; height: auto;">
            </td>

            <!-- Teks -->
            <td style="vertical-align: top; padding-left: 20px;text-align:left;">
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

    <h2>List Transaction Tenant</h2>

    <table style="border:1px solid;">
    <thead>
        <tr>
            <th>No</th>
            <th>Transaction Date</th>
            <th>Tenant Name</th>
            <th>Registered By</th>
            <th>Email</th>
            <th>Electricity</th>
            <th>Harga Booth</th>
            <th>Additional Price</th>
            <th>Total Price</th>
        </tr>
    </thead>
    <tbody>
        @php $no = 1; @endphp
        @foreach ($transaksiList as $transaction)
        <tr style="border: 1px solid;">
            <td>{{ $no++ }}</td>
            <td>{{ $transaction->created_at->format('d M Y') }}</td>
            <td>{{ $transaction->tenant->tenant_name }}</td>
            <td>{{ $transaction->nama_pemesan }}</td>
            <td>{{ $transaction->tenant->user->email }}</td>
            <td>{{ intval($transaction->watt_listrik) }}</td>
            <td class="right-text">Rp {{ number_format($transaction->event->harga, 0, ',', '.') }}</td>
            <td class="right-text">Rp {{ number_format($transaction->total_price - $transaction->event->harga, 0, ',', '.') }}</td>
            <td class="right-text">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </tbody>
    </table>

    

</body>
</html>
