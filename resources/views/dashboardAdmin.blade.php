@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Dashboard</h1>
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
                    @if($ongoingEvent)
                        <p class="event-title">{{ $ongoingEvent->event_name }}</p>
                        <p>{{ $ongoingEvent->place }}</p>
                        <p>{{ \Carbon\Carbon::parse($ongoingEvent->start_date)->format('d/m/Y') }}</p>
                        <a href="{{ route('dashboard.admin.event') }}">Check More Detail →</a>
                    @else
                        <p>Tidak ada event yang sedang berlangsung.</p>
                    @endif
                </div>
                <div class="event-card">
                    <h3>Upcoming Event</h3>
                    @if($upcomingEvent)
                        <p class="event-title">{{ $upcomingEvent->event_name }}</p>
                        <p>{{ $upcomingEvent->place }}</p>
                        <p>{{ \Carbon\Carbon::parse($upcomingEvent->start_date)->format('d/m/Y') }}</p>
                        <a href="{{ route('dashboard.admin.event') }}">Check More Detail →</a>
                    @else
                        <p>Tidak ada event yang akan datang.</p>
                    @endif
                </div>
            </div>

            <!-- Staff Commission Table -->
            <div class="staff-commission">
                <h2>Staff Commission - {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Staff Name</th>
                            <th>Total Referrals</th>
                            <th>Total Commission</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($komisi as $k)
                            <tr>
                                <td>#{{ $loop->iteration }}</td>
                                <td>{{ $k->staff->nm_depan }} {{ $k->staff->nm_blkg }}</td>
                                <td>{{ $k->referral_usage }}</td>
                                <td>Rp{{ number_format($k->total_komisi, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">Tidak ada data komisi bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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
                            <th>Capital</th>
                            <th>Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($latestEvents as $event)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($event->finish_date)->format('d/m/Y') }}</td>
                                <td>{{ $event->event_name }}</td>
                                <td>{{ $event->place }}</td>
                                <td>Rp {{ number_format($event->capital, 0, ',', '.') }}</td>
                                <td>
                                    @if ($event->revenue !== null)
                                        Rp{{ number_format($event->revenue, 0, ',', '.') }}
                                    @else
                                        <span style="color: gray;">Belum diisi</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Belum ada event yang selesai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
@endsection
