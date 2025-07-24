@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Detail Commision</h1>
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
            
            <a href="{{ $from === 'history' ? route('dashboard.admin.transactionhist') : route('dashboard.admin.komisi') }}" class="btn-back add-staff">
                <span class="material-symbols-outlined">chevron_left</span>          
                <span class="nav-label">Back</span>
            </a>
            <div class="form-column-2">
                <div class="details-data">
                    <h3>Data Staff Commision</h3>
                    <p><strong>Name:</strong> {{ $komisi->staff->nm_depan }} {{ $komisi->staff->nm_blkg }}</p>
                    <p><strong>Departement:</strong> {{ $komisi->staff->departemen->department }}</p>
                </div>
                <div class="details-data">
                    <br>
                    <p><strong>No. Telepon:</strong> {{ $komisi->staff->user->no_telp }}</p>
                    <p><strong>Regist Date:</strong> {{ $komisi->created_at ? $komisi->created_at->format('d-m-Y') : '-' }}</p>
                </div>
            </div>
            <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Tenant Name</th>
                            <th>Transaction Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($komisi->detailKomisi as $detail)
                            @if ($detail->transaksi && $detail->transaksi->status === 'Successful')
                                <tr>
                                    <td>{{ $detail->transaksi->event->event_name ?? '-' }}</td>
                                    <td>{{ $detail->tenant->tenant_name ?? '-' }}</td>
                                    <td>{{ $komisi->created_at ? $komisi->created_at->format('d-m-Y') : '-' }}</td>
                                    
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4">Tidak ada transaksi sukses untuk komisi ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
        </div>
        
    </div>
@endsection
