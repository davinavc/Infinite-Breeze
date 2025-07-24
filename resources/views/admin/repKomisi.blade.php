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
            <h2>Report Commision</h2>
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            <div class="button-group">
                <div class="group-button-filter">
                    <div class="filter-group">
                        <form method="GET" action="{{ route('dashboard.admin.repkomisi') }}">
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
                            <a href="{{ route('admin.report.allkomisi', ['bulan' => request('bulan'), 'tahun' => request('tahun'), 'all_year' => request('all_year')]) }}" target="_blank" class="btn-download">
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
                        <th>Name</th>
                        <th>Department</th>
                        <th>Status</th>
                        <th>Referral Usage</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $staff)
                        @if ($staff['referral_usage'] > 0)
                        <tr>
                            <td>{{ $staff['name'] }}</td>
                            <td>{{ $staff['department'] }}</td>
                            <td>{{ $staff['status'] }}</td>
                            <td>{{ $staff['referral_usage'] }}</td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    <a href="{{ route('admin.report.komisi', ['id' => $staff['staff_id'], 'bulan' => request('bulan'), 'tahun' => request('tahun'), 'all_year' => request('all_year')]) }}" target="_blank" class="btn-edit" style="display: flex; align-items: center;">
                                        <span class="material-symbols-outlined">download</span>
                                        Download
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection