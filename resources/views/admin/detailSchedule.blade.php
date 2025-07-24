@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>History Tenant</h1>
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
            <h2>Pendaftar Tanggal {{ $jadwal->tgl_event }} - Event: {{ $jadwal->event->event_name }}</h2>
            <table class="table">
        <thead>
            <tr>
                <th>Nama Staff</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal->pendaftar as $pendaftaran)
            <tr>
                <td>{{ $pendaftaran->staff->nm_depan }} {{ $pendaftaran->staff->nm_blkg }}</td>
                <td>{{ $pendaftaran->status }}</td>
                <td>
                    @if($pendaftaran->status === 'Pending')
                        <form action="{{ route('jadwal.konfirmasi', $pendaftaran->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Konfirmasi</button>
                        </form>
                        <form action="{{ route('jadwal.cancel', $pendaftaran->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                        </form>
                    @else
                        <em>{{ $pendaftaran->status }}</em>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
        </div>
    </div>
@endsection
