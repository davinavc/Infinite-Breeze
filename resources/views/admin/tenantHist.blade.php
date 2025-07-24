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
            <h2>List Tenant</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Category</th>
                        <th>Join Date</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($inactiveTenant as $tenant)
                    <tr>
                        <td>{{ $tenant->tenant_name }}</td>
                        <td>{{ $tenant->user->email }}</td>
                        <td>{{ $tenant->user->no_telp }}</td>
                        <td>{{ $tenant->category_name }}</td>
                        <td>{{ $tenant->created_at->format('d-m-Y') }}</td>
                        <td class="button-group">
                            <div class="group-button-action">
                                <a href="{{ route('admin.tenant.detail', ['id' => $tenant->id, 'from' => 'history']) }}" class="btn-details" style="display: flex; align-items: center;">
                                    <span class="material-symbols-outlined">info</span>
                                        Details
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Tidak ada tenant history.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
