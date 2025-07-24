@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
<header class="content-header">
        <h1>Department</h1>
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
            <h2>Data Department</h2>
            @if(session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('department.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $department->id }}">
                <div class="form-column-2">
                    <div class="form-group">
                        <label for="Department">Department Name</label>
                        <input type="text" name="department" value="{{ $department->department }}" required>
                    </div>
                </div>
                <div class="form-button-group">
                    <button type="submit" class="add-staff">
                        <span class="dropdown-icon material-symbols-outlined">edit</span>
                        Update
                    </button>
                    <a href="{{ route('dashboard.admin.dept') }}" class="add-staff btn-cancel">
                        <span class="material-symbols-outlined">close</span>
                        <span class="nav-label">Cancel</span>
                    </a>
                </div>
            </form>    
        </div>
    </div>
@endsection
