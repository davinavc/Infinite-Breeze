@extends('layouts.app-staff')

@section('title', 'Staff Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Tenant</h1>
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
            <h2>List Tenant</h2>
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            <table>
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Follow Up</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($tenants as $tenant)
                    <tr>
                        <td>{{ $tenant->tenant_name }} </td>
                        <td>{{ $tenant->user->email }} </td>
                        <td>{{ $tenant->user->no_telp }}</td>
                        <td class="button-group">
                            <div class="group-button-action">
                                <a href="{{ route('admin.tenant.detail', ['id' => $tenant->id, 'from' => 'active']) }}" class="btn-edit" style="display: flex; align-items: center;">
                                    <span class="material-symbols-outlined">info</span>
                                        Follow Up
                                </a>
                            </div>
                        </td>
                        <td class="button-group">
                            <div class="group-button-action">
                                <a href="{{ route('admin.tenant.detail', ['id' => $tenant->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                    <span class="material-symbols-outlined">info</span>
                                        Details
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Tidak ada data Tenant.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
