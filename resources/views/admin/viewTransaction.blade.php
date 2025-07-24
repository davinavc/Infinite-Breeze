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
            <h2>Verify Transaction</h2>
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            <a href="{{ route('dashboard.admin.transaction') }}" class="add-staff">
                <span class="dropdown-icon material-symbols-outlined">verified_user</span>
                Verify
            </a>
            <a href="{{ route('dashboard.admin.viewtransaction') }}" class="add-staff-inactive" style="gap:5px">
                <span class="dropdown-icon material-symbols-outlined">visibility</span>
                View
            </a>
            <table>
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Payed Price</th>
                        <th>Payments</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Details</th>
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
                            <td>{{ $event->event_name }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') }} - 
                                {{ \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') }}
                            </td>
                            <td>Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if($trx->bukti_transaksi)
                                    <a href="{{ asset('storage/' . $trx->bukti_transaksi) }}" target="_blank">View</a>
                                @else
                                    <span style="color: red;">No proof</span>
                                @endif
                            </td>
                            <td>{{ ucfirst($status) }}</td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    @if($status === 'Successful')
                                        <div class="group-button-action">
                                            <a href="{{ route('admin.report.invoice', ['tenantId' => $tenant->id, 'eventId' => $event->id, 'from' => 'transaction']) }}" target="_blank" class="btn-edit">
                                                <span class="material-symbols-outlined">download</span>
                                                Download
                                            </a>
                                        </div>
                                    @elseif($status === 'Rejected')
                                        <span class="text-danger">Ditolak</span>
                                    @endif
                                    </div>
                            </td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    <a href="{{ route('admin.transaksi.show', ['id' => $trx->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                        <span class="material-symbols-outlined">info</span>
                                            Details
                                    </a>
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
