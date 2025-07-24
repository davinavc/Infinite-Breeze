@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Detail Transaction</h1>
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
            
            <a href="{{ $from === 'history' ? route('dashboard.admin.transactionhist') : route('dashboard.admin.viewtransaction') }}" class="btn-back add-staff">
                <span class="material-symbols-outlined">chevron_left</span>          
                <span class="nav-label">Back</span>
            </a>
            <div class="form-column-2">
                <div class="details-data">
                    <h3>Data Transaksi Tenant</h3>
                    <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo {{ $tenant->tenant_name }}" style="max-width: 200px; max-height: 200px;">
                    <p><strong>Tenant Name:</strong> {{ $tenant->tenant_name }}</p>
                    <p><strong>Category:</strong> {{ $tenant->category_name }}</p>
                    <p><strong>Email:</strong> {{ $tenant->user->email }}</p>
                    <p><strong>No. Telepon:</strong> {{ $tenant->user->no_telp }}</p>
                    <p><strong>Bank:</strong> {{ $tenant->nama_bank }}</p>
                    <p><strong>Rekening:</strong> {{ $tenant->rekening }}</p>
                    @if ($transaksi)
                        <p><strong>Board Name:</strong> {{ $transaksi->papan_nama }}</p>
                        <p><strong>Additional Price:</strong> Rp {{ number_format($transaksi->total_price - $event->harga, 0,',','.') }}</p>
                        <p><strong>Electricity Usage:</strong> {{ intval($transaksi->watt_listrik) }}</p>
                        <p><strong>Total Price:</strong> Rp {{ number_format($transaksi->total_price, 0, ',', '.') }}</p>
                        <p><strong>Transaction Date:</strong> {{ $transaksi->created_at ? $transaksi->created_at->format('d-m-Y') : '-' }}</p>

                    @else
                        <p><strong>Board Name:</strong> -</p>
                        <p><strong>Additional Price:</strong> Rp 0</p>    
                        <p><strong>Electricity Usage:</strong> -</p>
                        <p><strong>Total Price:</strong> Rp 0</p>
                        <p><strong>Transaction Date:</strong> -</p>
                    @endif
                </div>
                <div class="details-data">
                    <h3>Data Event</h3>
                    <img src="{{ asset('storage/' . $event->poster) }}" alt="Logo {{ $event->event_name }}" style="max-width: 200px; max-height: 200px;">
                    <p><strong>Nama:</strong> {{ $event->event_name }}</p>
                    <p><strong>Theme:</strong> {{ $event->theme }}</p>
                    <p><strong>Place:</strong> {{ $event->place }}</p>
                    <p><strong>Supported Electricity:</strong> {{ $event->supported_electricity }} Ampere</p>
                    <p><strong>Booth Price:</strong> Rp {{ number_format($event->harga, 0, ',', '.') }}</p>
                    <p><strong>Date:</strong> {{ ($event->start_date && $event->finish_date) ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : '-'}}</p>

                </div>
            </div>
        </div>
        
    </div>
@endsection
