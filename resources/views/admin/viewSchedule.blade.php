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
        <div class="staff-list">
            <h2>List  Schedule</h2>
            <a href="{{ route('dashboard.admin.schedule') }}" class="add-staff">
                <span class="dropdown-icon material-symbols-outlined">verified_user</span>
                Verify
            </a>
            <a href="{{ route('dashboard.admin.viewschedule') }}" class="add-staff-inactive" style="gap:5px">
                <span class="dropdown-icon material-symbols-outlined">visibility</span>
                View
            </a>
            <a href="{{ route('dashboard.admin.addschedule') }}" class="add-staff">
                <span class="dropdown-icon material-symbols-outlined">add</span>
                Add
            </a>

            @if(session('success'))
                    <div class="success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                    <div class="text-danger">{{ session('error') }}</div>
            @endif
            <div class="form-row-3">
                <div class="form-group">
                    <label for="event_idv">Event:</label>
                    <select name="event_id" id="event_idv">
                        <option value="">-- Pilih Event --</option>
                        @foreach ($events as $event)
                            <option value="{{ $event->id }}" data-start="{{ $event->start_date }}" data-end="{{ $event->finish_date }}">
                                {{ $event->event_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="start_date">Event Start Date:</label>
                    <input type="date" name="start_date" id="start_date" value="" disabled>
                </div>
                <div class="form-group">
                    <label for="finish_date">Event Finish Date:</label>
                    <input type="date" name="finish_date" id="finish_date" value="" disabled>
                </div>
            </div>
            <div id="scheduleTableView"></div>

        </div>
    </div>

<script id="jadwal-data" type="application/json">
    {!! json_encode($jadwalStaff) !!}
</script>

@endsection
