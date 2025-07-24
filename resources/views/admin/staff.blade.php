@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Staff</h1>
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
            <h2>List Staff</h2>
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            <a href="{{ route('dashboard.admin.addstaff') }}" class="add-staff">
                <span class="dropdown-icon material-symbols-outlined">add</span>
                Add Staff
            </a>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Join Date</th>
                        <th>Status</th>
                        <th>Referral Code</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($staffList as $staff)
                    <tr>
                        <td>{{ $staff->nm_depan }} {{ $staff->nm_blkg }}</td>
                        <td>{{ $staff->departemen->department ?? '-' }}</td>
                        <td>{{ $staff->created_at->format('d-m-Y') }}</td>
                        <td>{{ $staff->status }}</td>
                        <td>{{ $staff->referral_code }}</td>
                        <td class="button-group">
                                <div class="group-button-action">
                                    <a href="{{ route('admin.staff.edit', ['id' => $staff->id]) }}" class="btn-edit" style="display: flex; align-items: center;">
                                        <span class="material-symbols-outlined">edit</span>
                                        Edit
                                    </a>
                                </div>
                            </td>
                        <td class="button-group">
                            <div class="group-button-action">
                                <a href="{{ route('admin.staff.detail', ['id' => $staff->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                    <span class="material-symbols-outlined">info</span>
                                        Details
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Tidak ada data Staff.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection