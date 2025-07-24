@extends('layouts.app-staff')

@section('title', 'Staff Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Event</h1>
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
            <h2>Up Coming Event</h2>
                @if(session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Event Theme</th>
                            <th>Event Date</th>
                            <th>Place</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($upcomingEvents as $event)
                            <tr>
                                <td>{{ $event->event_name}}</td>
                                <td>{{ $event->theme}}</td>
                                <td>{{ ($event->start_date && $event->finish_date) ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : '-'}}</td>
                                <td>{{ $event->place }}</td>
                                <td>{{ $event->status_pendaftaran }}</td>
                                <td class="button-group">
                                    <div class="group-button-action">
                                         @if(!$event->sudah_daftar && $event->jadwalStaff->count() > 0)
                                            <a href="{{ route('event.register', ['id' => $event->id]) }}" class="btn-register">
                                                <span class="material-symbols-outlined">checkbook</span> Register
                                            </a>
                                        @elseif($event->jadwalStaff->count() == 0)
                                            <span style="color: grey;">Belum ada jadwal</span>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </td>
                                <td class="button-group">
                                    <div class="group-button-action">
                                        <a href="{{ route('staff.event.detail', ['id' => $event->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                            <span class="material-symbols-outlined">info</span>
                                                Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Tidak ada data event.</td>
                            </tr>
                        @endforelse
                    </tbody>    
                </table>
            </div>
        </div>
        <div class="staff-list">
            <h2>On Going Event</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Event Theme</th>
                            <th>Event Date</th>
                            <th>Place</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ongoingEvents as $event)
                            <tr>
                                <td>{{ $event->event_name}}</td>
                                <td>{{ $event->theme}}</td>
                                <td>{{ ($event->start_date && $event->finish_date) ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : '-'}}</td>
                                <td>{{ $event->place }}</td>
                                <td class="button-group">
                                    @if($event->sudah_daftar)
                                    <div class="group-button-action">
                                        <a href="{{ route('staff.detail.schedule', ['id' => $event->id]) }}" class="btn-register">
                                            <span class="material-symbols-outlined">schedule</span> Schedule
                                        </a>
                                    </div>
                                    @else
                                        Tidak Mendaftar
                                    @endif
                                </td>
                                <td class="button-group">
                                    <div class="group-button-action">
                                        <a href="{{ route('staff.event.detail', ['id' => $event->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                            <span class="material-symbols-outlined">info</span>
                                                Details
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">Tidak ada data event.</td>
                            </tr>
                        @endforelse
                    </tbody>    
                </table>
            </div>
        </div>
    </div>

@endsection