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
            
            <a href="{{ $from === 'history' ? route('dashboard.admin.tenanthist') : route('dashboard.admin.tenant') }}" class="btn-back add-staff">
                <span class="material-symbols-outlined">chevron_left</span>          
                <span class="nav-label">Back</span>
            </a>
            <div class="details-data">
                <img src="{{ asset('storage/' . $tenant->logo) }}" alt="Logo {{ $tenant->tenant_name }}" style="max-width: 200px; max-height: 200px;">
                <p><strong>Nama:</strong> {{ $tenant->tenant_name }}</p>
                <p><strong>Email:</strong> {{ $tenant->user->email }}</p>
                <p><strong>No. Telepon:</strong> {{ $tenant->user->no_telp }}</p>
                <p><strong>Category:</strong> {{ $tenant->category_name }}</p>
                <p><strong>Alamat:</strong> {{ $tenant->alamat }}</p>
                <p><strong>Bank:</strong> {{ $tenant->nama_bank }}</p>
                <p><strong>Rekening:</strong> {{ $tenant->rekening }}</p>
                <p><strong>Tanggal Bergabung:</strong> {{ $tenant->user->created_at->format('d-m-Y') }}</p>
            </div>
        </div>
        
    </div>
@endsection
