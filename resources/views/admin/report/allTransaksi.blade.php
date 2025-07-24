<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="{{ public_path('img/logo_white.png') }}" type="image/icon type">
    <title>Report Semua Event</title>
    <link rel="stylesheet" href="{{ public_path('css/report.css') }}">
</head>
<body>
    <h1>Report Semua Event Bulan {{ $bulan ?? '-' }} Tahun {{ $tahun ?? '-' }}</h1>

    @foreach ($events as $e)
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

        <h2>List Transaction Tenant</h2>
        <table style="border:1px solid; width: 100%; border-collapse: collapse;">
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
                @foreach ($e->transactions as $transaction)
                    <tr style="border: 1px solid;">
                        <td>{{ $no++ }}</td>
                        <td>{{ $transaction->created_at->format('d M Y') }}</td>
                        <td>{{ $transaction->tenant->tenant_name ?? '-' }}</td>
                        <td>{{ $transaction->nama_pemesan }}</td>
                        <td>{{ $transaction->tenant->user->email ?? '-' }}</td>
                        <td>{{ intval($transaction->watt_listrik) }}</td>
                        <td class="right-text">Rp {{ number_format($e->harga, 0, ',', '.') }}</td>
                        <td class="right-text">Rp {{ number_format($transaction->total_price - $e->harga, 0, ',', '.') }}</td>
                        <td class="right-text">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

</body>
</html>
