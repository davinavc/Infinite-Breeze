@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Detail Event</h1>
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
            
            <a href="{{ $from === 'history' ? route('dashboard.admin.eventhist') : route('dashboard.admin.event') }}" class="btn-back add-staff">
                <span class="material-symbols-outlined">chevron_left</span>          
                <span class="nav-label">Back</span>
            </a>
            <div class="details-data">
                <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster {{ $event->poster }}" style="max-width: 200px; max-height: 200px;">
                <p><strong>Event Name:</strong> {{ $event->event_name }}</p>
                <p><strong>Event Theme :</strong> {{ $event->theme }}</p>
                <p><strong>Place :</strong> {{ $event->place }}</p>
                <p><strong>Start Date:</strong> {{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') : ' - ' }}</p>
                <p><strong>Finish Date:</strong> {{ $event->finish_date ? \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : ' - ' }}</p>
                <p><strong>Tenant Quota:</strong> {{ $event->tenant_quota }}</p>
                <p><strong>Supported Electricity:</strong> {{ $event->supported_electricity ?? '-' }}</p>
                <p><strong>Price Additional Electricity (Watt):</strong> Rp {{ number_format($event->price_per_watt, 2, ',', '.') }}</p>
                <p><strong>Booth Price:</strong> Rp {{ number_format($event->harga, 2, ',', '.') }}</p>
                <p><strong>Capital:</strong> Rp {{ number_format($event->capital, 2, ',', '.') }}</p>
                <p><strong>Revenue:</strong> Rp {{ number_format($event->revenue, 2, ',', '.') ?? '-'}}</p>
            </div>
        </div>
        
    </div>
@endsection
