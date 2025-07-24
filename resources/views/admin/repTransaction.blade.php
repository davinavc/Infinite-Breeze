@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Report</h1>
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
            <h2>Report Transaction</h2>
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            <div class="button-group">
                <div class="group-button-filter">
                    <div class="filter-group">
                        <form method="GET" action="{{ route('dashboard.admin.reptransaction') }}">
                            <label>Bulan:</label>
                            <input type="number" name="bulan" value="{{ request('bulan') }}" min="1" max="12">
                            <label>Tahun:</label>
                            <input type="number" name="tahun" value="{{ request('tahun') }}" min="2013">
                            
                            <button class="filtering" type="submit">Filter</button>

                            <label style="display:flex;align-items:center;margin-top:5px;">
                                <input type="checkbox" name="all_year" value="1" {{ request('all_year') ? 'checked' : '' }} style="height:15px;width:10%;">
                                Tampilkan Semua Tahun
                            </label>
                        </form>
                    </div>
                    <div class="filter-group">
                        <div class="group-button-action">
                            <a href="{{ route('admin.report.alltransaksi', ['bulan' => request('bulan'), 'tahun' => request('tahun'), 'all_year' => request('all_year')]) }}" target="_blank" class="btn-download">
                                <span class="material-symbols-outlined">download</span>
                                Download All
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Total Tenant</th>
                        <th>Total Nominal</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($transaksiList as $trxGroup)
                    <tr>
                        <td>{{ $trxGroup['event']->event_name ?? '-' }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($trxGroup['event']->start_date)->format('d-m-Y') ?? '-' }} - 
                            {{ \Carbon\Carbon::parse($trxGroup['event']->finish_date)->format('d-m-Y') ?? '-' }}
                        </td>

                        <td>{{ $trxGroup['total_tenant'] ?? '-' }}</td>
                        <td>{{ $trxGroup['total_nominal'] ?? '-' }}</td>
                        <td class="button-group">
                                <div class="group-button-action">
                                    <a href="{{ route('admin.report.transaksi', ['id' => $trxGroup['event']->id]) }}" target="_blank" class="btn-edit" style="display: flex; align-items: center;">
                                        <span class="material-symbols-outlined">download</span>
                                        Download
                                    </a>
                                </div>
                            </td>
                        <td class="button-group">
                            <div class="group-button-action">
                                <a href="{{ route('admin.detail.reptransaksi', ['id' => $trxGroup['event']->id, 'from' => 'report']) }}" class="btn-details" style="display: flex; align-items: center;">
                                    <span class="material-symbols-outlined">info</span>
                                        Details
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Tidak ada data transaksi.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection