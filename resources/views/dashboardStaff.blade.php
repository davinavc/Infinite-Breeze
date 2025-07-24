@extends('layouts.app-staff')

@section('title', 'Staff Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Dashboard Staff</h1>
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
            <!-- Event Ongoing & Upcoming -->
            <div class="event-cards">
                <div class="event-card">
                    <h3>Event Ongoing</h3>
                    @if ($ongoing)
                        <p class="event-title">{{ $ongoing->event_name }}</p>
                        <p>{{ $ongoing->place }}</p>
                        <p>{{ \Carbon\Carbon::parse($ongoing->start_date)->format('d/m/Y') }}</p>
                        <a href="{{ route('dashboard.staff.event') }}">Check More Detail →</a>
                    @else
                        <p>Tidak ada event yang sedang berlangsung</p>
                    @endif
                </div>
                <div class="event-card">
                    <h3>Upcoming Event</h3>
                     @if ($upcoming)
                        <p class="event-title">{{ $upcoming->event_name }}</p>
                        <p>{{ $upcoming->place }}</p>
                        <p>{{ \Carbon\Carbon::parse($upcoming->start_date)->format('d/m/Y') }}</p>
                        <a href="{{ route('dashboard.staff.event') }}">Check More Detail →</a>
                    @else
                        <p>Tidak ada event yang akan datang</p>
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
                            <th>Work Day</th>
                            <th>Commision</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($latestEvents && count($latestEvents) > 0)
                            @foreach ($latestEvents as $event)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') }} - {{ \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') }}</td>
                                    <td>{{ $event->event_name }}</td>
                                    <td>{{ $event->place }}</td>
                                    <td>{{ $event->work_days ?? '-' }}</td> <!-- pastikan $event->work_days tersedia -->
                                    <td>
                                        @if (is_numeric($komisiPerEvent[$event->id]))
                                            Rp{{ number_format($komisiPerEvent[$event->id]) }}
                                        @else
                                            {{ $komisiPerEvent[$event->id] ?? '-' }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">Belum ada event yang pernah diikuti</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="form-column-2" style="margin-left:20px;margin-top:10px">
                    <div class="form-group">
                        <h3>TOTAL</h3>
                    </div>
                    <div class="form-group" style="margin-left:27rem">

                        <h3 id="total-cost">
                            @if (is_numeric($totalSemuaEvent))
                                Rp {{ number_format($totalSemuaEvent) }}
                            @else
                                {{ $totalSemuaEvent ?? '-' }}
                            @endif
                        </h3>
                    </div>
                </div>
            </div>
        </div>
@endsection

