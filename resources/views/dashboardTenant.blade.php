@extends('layouts.app-tenant')

@section('title', 'Tenant Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Dashboard Tenant</h1>
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
        <div class="event-cards">
            <div class="event-card">
                <h3>Event Ongoing</h3>
                @if ($ongoing)
                    <p class="event-title">{{ $ongoing->event_name }}</p>
                    <p>{{ $ongoing->place }}</p>
                    <p>{{ \Carbon\Carbon::parse($ongoing->start_date)->format('d/m/Y') }}</p>
                    <a href="{{ route('dashboard.tenant.event') }}">Check More Detail →</a>
                @else
                    <p>There are no ongoing events you're participating in</p>
                @endif
            </div>
            <div class="event-card">
                <h3>Upcoming Event</h3>
                @if ($upcoming)
                    <p class="event-title">{{ $upcoming->event_name }}</p>
                    <p>{{ $upcoming->place }}</p>
                    <p>{{ \Carbon\Carbon::parse($upcoming->start_date)->format('d/m/Y') }}</p>
                    <a href="{{ route('dashboard.tenant.event') }}">Check More Detail →</a>
                @else
                    <p>No upcoming events. <a href="{{ route('dashboard.tenant.event') }}">Register now!</a></p>
                @endif
            </div>
        </div>

        <!-- Latest Event Table -->
        <div class="latest-event">
            <h2>Latest Event</h2>
            <table>
                <thead>
                    <tr>
                        <th>Event Date</th>
                        <th>Event Name</th>
                        <th>Place</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestEvents as $event)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($event->finish_date)->format('d/m/Y') }}</td>
                            <td>{{ $event->event_name }}</td>
                            <td>{{ $event->place }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No completed events yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection