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
        <!-- Department Table -->
        <div class="staff-list">
            <h2>Data Schedule</h2>
             
            <form action="{{ route('admin.schedule.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $jadwalStaff->id }}">
                <div class="form-column-2">
                    <div class="form-group">
                        <label for="maks_staff">Max Staff</label>
                        <input type="text" name="maks_staff" value="{{ $jadwalStaff->maks_staff }}" required>
                    </div>
                </div>
                <div class="form-button-group">
                    <button type="submit" class="add-staff">
                        <span class="dropdown-icon material-symbols-outlined">edit</span>
                        Update
                    </button>
                    <a href="{{ route('dashboard.admin.viewschedule') }}" class="add-staff btn-cancel">
                        <span class="material-symbols-outlined">close</span>
                        <span class="nav-label">Cancel</span>
                    </a>
                </div>
            </form>    
        </div>
    </div>
@endsection
