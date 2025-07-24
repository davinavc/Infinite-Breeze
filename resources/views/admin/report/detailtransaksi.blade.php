@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Transaction</h1>
        <div class="header-button">
            <button id="toggleDarkMode">
                <span class="dropdown-icon material-symbols-outlined">dark_mode</span>
            </button>
            <button>
                <span class="dropdown-icon material-symbols-outlined">account_circle</span>
            </button>
        </div>
    </header>

    <div class="dashboard-content">
        <div class="staff-list">
            <h2>{{ $event->event_name}}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Date</th>
                        <th>Payed Price</th>
                        <th>Payment Proof</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $trx)
                        @php
                            $event = $trx->event;
                            $tenant = $trx->tenant;
                            $status = $trx->status;
                        @endphp
                        <tr>
                            <td>{{ $tenant->tenant_name }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($trx->created_at)->format('d-m-Y') }}
                            </td>
                            <td>Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if($trx->bukti_transaksi)
                                    <a href="{{ asset('storage/' . $trx->bukti_transaksi) }}" target="_blank">View</a>
                                @else
                                    <span style="color: red;">No proof</span>
                                @endif
                            </td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    <div class="group-button-action">
                                        <a href="{{ route('admin.report.invoice', ['tenantId' => $tenant->id, 'eventId' => $event->id, 'from' => 'transaction']) }}" target="_blank" class="btn-edit">
                                            <span class="material-symbols-outlined">download</span>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11">Belum ada transaksi event.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
