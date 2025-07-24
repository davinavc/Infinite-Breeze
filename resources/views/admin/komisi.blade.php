@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Laporan Komisi Bulanan - {{ $bulan }}/{{ $tahun }}</h1>
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
                <h2>Data Komisi</h2>
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
                                <input type="number" name="bulan" value="{{ request('bulan') }}" min="1" max="12">
                                <label>Tahun:</label>
                                <input type="number" name="tahun" value="{{ request('tahun') }}" min="2013">
                                
                                <button class="filtering" type="submit">Filter</button>
                                <label style="display:flex;align-items:center;margin-top:5px;">
                                    <input type="checkbox" name="all_year" value="1" {{ request('all_year') ? 'checked' : '' }} style="height:15px;width:10%;">
                                    Tampilkan Semua Tahun dan Bulan
                                </label>
                            </form>
                        </div>
                        <div class="filter-group">
                            <div class="group-button-action">
                                <a href="{{ route('admin.report.allkomisi', ['bulan' => request('bulan'), 'tahun' => request('tahun'), 'all_year' => request('all_year')]) }}" target="_blank" class="btn-download">
                                    <span class="material-symbols-outlined">download</span>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Staff Name</th>
                            <th>Referral</th>
                            <th>Referral Usage</th>
                            <th>Total Komisi</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($komisi as $k)
                        <tr>
                            <td>{{ $k->staff->nm_depan }} {{ $k->staff->nm_blkg }}</td>
                            <td>{{ $k->staff->referral_code }}</td>
                            <td>{{ $k->referral_usage }}</td>
                            <td>Rp {{ number_format($k->total_komisi, 2) }}</td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    <a href="{{ route('admin.komisi.detail', ['id' => $k ->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                        <span class="material-symbols-outlined">info</span>
                                            Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5">Tidak ada data komisi bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
@endsection