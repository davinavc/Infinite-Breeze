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
            <h2>Add Schedule</h2>
            <a href="{{ route('dashboard.admin.schedule') }}" class="add-staff">
                <span class="dropdown-icon material-symbols-outlined">verified_user</span>
                Verify
            </a>
            <a href="{{ route('dashboard.admin.viewschedule') }}" class="add-staff" style="gap:5px">
                <span class="dropdown-icon material-symbols-outlined">visibility</span>
                View
            </a>
            <a href="{{ route('dashboard.admin.addschedule') }}" class="add-staff-inactive">
                <span class="dropdown-icon material-symbols-outlined">add</span>
                Add
            </a>
            <form action="{{ route('admin.schedule.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row-3">
                    <div class="form-group">
                        <label for="event_id">Event:</label>
                        <select name="event_id" id="event_ids">
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

                <div id="schedule-table" style="margin-top: 20px;margin-bottom:20px;"></div>

                <div class="form-button-group">
                    <button type="submit" class="add-staff">
                        <span class="dropdown-icon material-symbols-outlined">draft</span> Submit
                    </button>
                    <a href="{{ route('dashboard.admin.schedule') }}" class="add-staff btn-cancel">
                        <span class="material-symbols-outlined">close</span> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
