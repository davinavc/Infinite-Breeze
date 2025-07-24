@extends('layouts.app-staff')

@section('title', 'Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>History Event</h1>
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
            <h2>List Event</h2>
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Event Date</th>
                        <th>Place</th>
                        <th>Work Days</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historyEvents as $event)
                    <tr>
                        <td>{{ $event->event_name}}</td>
                        <td>{{ ($event->start_date && $event->finish_date) ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : '-'}}</td>
                        <td>{{ $event->place}}</td>
                        <td>{{ $event->work_days}}</td>
                        <td class="button-group">
                            <div class="group-button-action">
                                <a href="{{ route('staff.event.detail', ['id' => $event->id, 'from' => 'history']) }}" class="btn-details" style="display: flex; align-items: center;">
                                    <span class="material-symbols-outlined">info</span>
                                        Details
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7">Tidak ada data event.</td>
                        </tr>
                    @endforelse
                </tbody>
        </div>
    </div>
@endsection
