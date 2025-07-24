@extends('layouts.app-tenant')

@section('title', 'Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Event</h1>
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
        <!-- Staff Commission Table -->
        <div class="staff-list">
            <h2>List Event</h2>
                @if(session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Event Theme</th>
                            <th>Event Date</th>
                            <th>Place</th>
                            <th>Status</th>
                            <th>Booth Price</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            @php
                                $tenantId = auth()->user()->tenant->id;

                                // Ambil registrasi
                                $registrasi = $event->registrations->where('tenant_id', $tenantId)->first();

                                // Cek apakah sudah buat transaksi
                                $sudahTransaksi = \App\Models\Transaksi::where('event_id', $event->id)
                                    ->where('tenant_id', $tenantId)
                                    ->exists();
                            @endphp
                            <tr>
                                <td>{{ $event->event_name}}</td>
                                <td>{{ $event->theme}}</td>
                                <td>{{ ($event->start_date && $event->finish_date) ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : '-'}}</td>
                                <td>{{ $event->place }}</td>
                                <td>{{ $event->status }}</td>
                                <td>Rp {{ number_format($event->harga, 0, ',', '.') }}</td>
                                <td class="button-group">
                                    <div class="group-button-action">
                                        @if (!$registrasi)
                                            <!-- Belum pernah registrasi -->
                                            <form method="POST" action="{{ route('tenant.event.confirm', ['id' => $event->id]) }}" class="form-register">
                                                @csrf
                                                <button type="submit" class="btn-register" onclick="return confirm('Yakin ingin registrasi ke event ini?')">
                                                    <span class="material-symbols-outlined">checkbook</span> Register
                                                </button>
                                            </form>

                                        @elseif ($registrasi->status === 'Cancelled')
                                            <!-- Pernah daftar tapi batal => boleh daftar lagi -->
                                            <form method="POST" action="{{ route('tenant.event.confirm', ['id' => $event->id]) }}" class="form-register">
                                                @csrf
                                                <button type="submit" class="btn-register" onclick="return confirm('Ingin registrasi ulang untuk event ini?')">
                                                    <span class="material-symbols-outlined">checkbook</span> Register 
                                                </button>
                                            </form>

                                        @elseif (in_array($registrasi->status, ['Pending', 'Confirmed']))
                                            <!-- Sudah daftar -->
                                                <a href="{{ route('dashboard.tenant.registration') }}" class="btn-edit" style="display: flex; align-items: center;">
                                                    <span class="material-symbols-outlined">fact_check</span>Check Regist
                                                </a>
                            
                                        @elseif ($registrasi->status === 'Rejected')
                                            <!-- Tidak bisa daftar lagi -->
                                            <span class="text-danger">Rejected</span>
                                        @endif
    
                                    </div>
                                </td>
                                <td class="button-group">
                                    <div class="group-button-action">
                                        <a href="{{ route('tenant.event.detail', ['id' => $event->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                            <span class="material-symbols-outlined">info</span>
                                                Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Tidak ada data event.</td>
                            </tr>
                        @endforelse
                    </tbody>    
                </table>
            </div>
        </div>
    </div>

@endsection