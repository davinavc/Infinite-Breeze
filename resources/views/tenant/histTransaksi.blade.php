@extends('layouts.app-tenant')

@section('title', 'Infinite Breeze')

@section('content')
<header class="content-header">
    <h1>Transaction</h1>
</header>

<div class="dashboard-content">
    <div class="staff-list">
        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="text-danger">{{ session('error') }}</div>
        @endif
        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Event Date</th>
                    <th>Place</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Technical Meeting (TM)</th>
                    <th>TM Link/Place</th>
                    <th>Action</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                @php
                    use Carbon\Carbon;
                    $today = Carbon::now();
                @endphp
                @forelse($transactions as $transaksi)
                @php
                    $trx = $transaksi->transaksi;
                    $statusTransaksi = $trx ? $trx->status : 'Not Paid';
                    $email = "infinitebreeze@example.com"; // Ganti dengan email tujuan sebenarnya
                    $subject = urlencode("Pertanyaan seputar event {$transaksi->event->event_name}");
                    $body = urlencode("Halo, saya dari tenant {$transaksi->tenant->tenant_name} yang mengikuti event {$transaksi->event->event_name}. Saya ingin bertanya mengenai event tersebut.");
                    $linkEmail = "mailto:{$email}?subject={$subject}&body={$body}";
                @endphp
                <tr>
                    <td>{{ $transaksi->event->event_name }}</td>
                    <td>{{ Carbon::parse($transaksi->event->start_date)->format('d-m-Y') }} s.d {{ Carbon::parse($transaksi->event->finish_date)->format('d-m-Y') }}</td>
                    <td>{{ $transaksi->event->place }}</td>
                    <td>Rp {{ number_format($transaksi->transaksi->total_price, 0, ',', '.') }}</td>
                    <td>{{ $statusTransaksi}}</td>
                    <td>{{ $transaksi->event->tm ? \Carbon\Carbon::parse($transaksi->event->tm)->format('d-m-Y') : '-' }}</td>
                    <td> 
                        @php
                            $tmLink = $transaksi->event->tm_link;
                            $isLink = filter_var($tmLink, FILTER_VALIDATE_URL);
                        @endphp

                        @if($isLink)
                            <a href="{{ $tmLink }}" target="_blank" class="text-link">
                                {{ $tmLink }}
                            </a>
                        @elseif($tmLink)
                            <span>{{ $tmLink }}</span>
                        @else
                            <span>-</span>
                        @endif
                    </td>
                    <td class="button-group">
                        <div class="group-button-action">
                            @if($statusTransaksi === 'Successful')
                                @php
                                    $today = Carbon::now();
                                    $finishDate = Carbon::parse($transaksi->event->finish_date);
                                @endphp

                                @if($today->lessThanOrEqualTo($finishDate))
                                    <a href="{{ route('tenant.transaksi.invoice', ['tenantId' => $transaksi->tenant->id, 'eventId' => $transaksi->event->id]) }}" target="_blank" class="btn-edit">
                                        <span class="material-symbols-outlined">download</span>
                                        Download <br>Invoice
                                    </a>
                                    <a href="{{ $linkEmail }}" target="_blank" class="btn-edit">
                                        <span class="material-symbols-outlined">call</span>
                                        Contact Us
                                    </a>
                                @else
                                    <a href="{{ route('tenant.transaksi.invoice', ['tenantId' => $transaksi->tenant->id, 'eventId' => $transaksi->event->id]) }}" target="_blank" class="btn-edit">
                                        <span class="material-symbols-outlined">download</span>
                                        Download <br>Invoice
                                    </a>
                                    <a href="{{ $linkEmail }}" target="_blank" class="btn-edit">
                                        <span class="material-symbols-outlined">call</span>
                                        Contact Us
                                    </a>
                                @endif
                            @elseif($statusTransaksi === 'Cancelled')
                                <span class="text-danger">Cancel</span>
                            @elseif($statusTransaksi === 'Rejected')
                                <span class="text-danger">Rejected</span>
                            @endif

                        </div>
                    </td>
                    <td class="button-group">
                        <div class="group-button-action">
                            <a href="{{ route('tenant.event.detail', ['id' => $transaksi->event->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                <span class="material-symbols-outlined">info</span>
                                Details
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Belum ada transaksi.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
