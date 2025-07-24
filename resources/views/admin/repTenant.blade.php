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
            <h2>Report Tenant</h2>
            <div class="button-group">
                <div class="group-button-filter">
                    <div class="filter-group">
                        <form method="GET" action="{{ route('dashboard.admin.reptenant') }}">
                            <label>Search Tenant:</label>
                            <input type="text" name="search">
                            
                            <button class="filtering" type="submit">Search</button>
                        </form>
                    </div>
                    <div class="filter-group">
                        <div class="group-button-action">
                            <a href="{{ route('admin.report.alltenant', ['search' => request('search')]) }}" target="_blank" class="btn-download">
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
                        <th>Tenant Name</th>
                        <th>Category</th>
                        <th>Join Date</th>
                        <th>Joined Event</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                 @forelse($tenants as $index => $tenant)
                    <tr>
                        <td>{{ $tenant->tenant_name }}</td>
                        <td>{{ $tenant->category_name }}</td>
                        <td>{{ $tenant->created_at->format('d-m-Y') }}</td>
                        <td>{{ $tenant->events_count }}</td>
                        <td>
                            <div class="group-button-action">
                                <a href="{{ route('admin.report.tenant', ['id' => $tenant->id]) }}" target="_blank" class="btn-edit">
                                    <span class="material-symbols-outlined">download</span>
                                    Download
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Tidak ada tenant history.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>
@endsection
