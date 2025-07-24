@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Detail Staff</h1>
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
            
            <a href="{{ $from === 'history' ? route('dashboard.admin.staffhist') : route('dashboard.admin.staff') }}" class="btn-back add-staff">
                <span class="material-symbols-outlined">chevron_left</span>          
                <span class="nav-label">Back</span>
            </a>
            <div class="details-data">
                <p><strong>Nama:</strong> {{ $staff->nm_depan }} {{ $staff->nm_blkg }}</p>
                <p><strong>Email:</strong> {{ $staff->user->email }}</p>
                <p><strong>No. Telepon:</strong> {{ $staff->no_telp }}</p>
                <p><strong>Tanggal Lahir:</strong> {{ $staff->birth_date }}</p>
                <p><strong>Alamat:</strong> {{ $staff->alamat }}</p>
                <p><strong>Departemen:</strong> {{ $staff->departemen->department ?? '-' }}</p>
                <p><strong>Status:</strong> {{ $staff->status }}</p>
                <p><strong>Tanggal Masuk:</strong> {{ $staff->created_at->format('d-m-Y') }}</p>
                <p><strong>Tanggal Keluar:</strong> {{ $staff->tgl_exit ? \Carbon\Carbon::parse($staff->tgl_exit)->format('d-m-Y') : '-' }}</p>
            </div>
        </div>
        
    </div>
@endsection
