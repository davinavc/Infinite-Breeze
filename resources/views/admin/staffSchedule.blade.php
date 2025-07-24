@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Schedule</h1>
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
            <a href="{{  route('dashboard.admin.viewschedule') }}" class="btn-back add-staff">
                <span class="material-symbols-outlined">chevron_left</span>          
                <span class="nav-label">Back</span>
            </a>
            <h2>List Staff</h2>
            <table>
                <thead>
                    <tr>
                        <th>Staff</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($staffs as $staff)
                    <tr>
                        <td>{{ $staff->staff->nm_depan }} {{ $staff->staff->nm_blkg }}</td>
                        <td>{{ $staff->staff->departemen->department }}</td>
                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Tidak ada Staff.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection