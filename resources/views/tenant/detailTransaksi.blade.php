@extends('layouts.app-tenant')

@section('title', 'Infinite Breeze')

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
            
            <a href="{{ $from === 'history' ? route('dashboard.tenant.eventhist') : route('dashboard.tenant.event') }}" class="btn-back add-staff" style="margin-bottom:10px;">
                <span class="material-symbols-outlined">chevron_left</span>          
                <span class="nav-label">Back</span>
            </a>
            <div class="details-data" >
                <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster {{ $event->poster }}" style="max-width: 200px; max-height: 200px;">
                <p><strong>Event Name:</strong> {{ $event->event_name }}</p>
                <p><strong>Event Theme :</strong> {{ $event->theme }}</p>
                <p><strong>Place :</strong> {{ $event->place }}</p>
                <p><strong>Start Date:</strong> {{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') : ' - ' }}</p>
                <p><strong>Finish Date:</strong> {{ $event->finish_date ? \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : ' - ' }}</p>
                <p><strong>Harga Booth:</strong> Rp {{ number_format($trx->booth_price, 0, ',', '.') }}</p>
                <p><strong>Biaya Tambahan Listrik:</strong> 
                    Rp {{ number_format($trx->total_price - $trx->booth_price, 0, ',', '.') }}
                </p>
                <p><strong>Total Dibayar:</strong> Rp {{ number_format($trx->total_price, 0, ',', '.') }}</p>
            </div>
        </div>
        
    </div>
@endsection
