@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Detail Tenant</h1>
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
            
            <a href="{{ $from === 'history' ? route('dashboard.admin.transactionhist') : route('dashboard.admin.registration') }}" class="btn-back add-staff">
                <span class="material-symbols-outlined">chevron_left</span>          
                <span class="nav-label">Back</span>
            </a>
            <div class="form-column-2">
                <div class="details-data">
                    <h3>Data Tenant</h3>
                    <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo {{ $tenant->tenant_name }}" style="max-width: 200px; max-height: 200px;">
                    <p><strong>Nama:</strong> {{ $tenant->tenant_name }}</p>
                    <p><strong>Category:</strong> {{ $tenant->category_name }}</p>
                    <p><strong>Alamat:</strong> {{ $tenant->alamat }}</p>
                    <p><strong>Email:</strong> {{ $tenant->user->email }}</p>
                    <p><strong>No. Telepon:</strong> {{ $tenant->user->no_telp }}</p>
                    <p><strong>Bank:</strong> {{ $tenant->nama_bank }}</p>
                    <p><strong>Rekening:</strong> {{ $tenant->rekening }}</p>
                    <p><strong>Regist Date:</strong> {{ $regist->created_at ? $regist->created_at->format('d-m-Y') : '-' }}</p>

                </div>
                <div class="details-data">
                    <h3>Data Event</h3>
                    <img src="{{ asset('storage/' . $event->poster) }}" alt="Logo {{ $event->event_name }}" style="max-width: 200px; max-height: 200px;">
                    <p><strong>Nama:</strong> {{ $event->event_name }}</p>
                    <p><strong>Theme:</strong> {{ $event->theme }}</p>
                    <p><strong>Place:</strong> {{ $event->place }}</p>
                    <p><strong>Date:</strong> {{ ($event->start_date && $event->finish_date) ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : '-'}}</p>

                </div>
            </div>
            
        </div>
        
    </div>
@endsection
