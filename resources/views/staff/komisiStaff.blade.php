@extends('layouts.app-staff')

@section('title', 'Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Commision - {{ $bulan }}/{{ $tahun }}</h1>
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
            <!-- Department Table -->
            <div class="staff-list">
                <h2>Data Commission {{ auth()->user()->staff->nm_depan }} {{ auth()->user()->staff->nm_blkg }}</h2>
                @if(session('success'))
                    <div class="success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="button-group">
                    <div class="group-button-filter">
                        <div class="filter-group">
                            <form method="GET" action="{{ route('dashboard.admin.komisi') }}">
                                <label>Bulan:</label>
                                <input type="number" name="bulan" value="{{ $bulan }}" min="1" max="12">
                                <label>Tahun:</label>
                                <input type="number" name="tahun" value="{{ $tahun }}" min="2013">
                                <button class="filtering" type="submit" >Filter</button>
                            </form>
                        </div>
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
                        @forelse($komisi as $k)
                            @forelse($k->detailKomisi as $detail)
                                <tr>
                                    <td>{{ $detail->transaksi->event->event_name ?? '-' }}</td>
                                    <td>{{ $detail->tenant->tenant_name ?? '-' }}</td>
                                    <td>{{ $detail->created_at ? $detail->created_at->format('d-m-Y') : '-' }}</td>
                                   
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">Tidak ada detail komisi.</td>
                                </tr>
                            @endforelse
                        @empty
                            <tr>
                                <td colspan="3">Tidak ada data komisi bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <br>
                <div class="form-column-2">
                    <div class="form-group">
                        <h3>Total</h3>
                    </div>
                    <h3 class="form-group subdata">Rp {{ number_format($totalSemuaKomisi, 2) }}</h3>
                </div>
            </div>
        </div>
@endsection