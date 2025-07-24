@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

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
                        <th>Event Theme</th>
                        <th>Event Date</th>
                        <th>Status</th>
                        <th>Booth Price</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                </thead>
                    @forelse($historyEvents as $event)
                    @php
                        $isIncomplete = !$event->revenue;
                    @endphp
                    <tr>
                        <td>{{ $event->event_name}}</td>
                        <td>{{ $event->theme}}</td>
                        <td>{{ ($event->start_date && $event->finish_date) ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : '-'}}</td>
                        <td>{{ $event->status }}</td>
                        <td>Rp {{ number_format($event->harga, 0, ',', '.') }}</td>
                        <td class="button-group">
                            @if ($isIncomplete)
                                <div class="group-button-action">
                                    <a href="{{ route('admin.event.edithist', ['id' => $event->id, 'from' => 'history']) }}" class="btn-edit" style="display: flex; align-items: center;">
                                        <span class="material-symbols-outlined">edit</span>
                                        Edit
                                    </a>
                                </div>
                            @else
                                -
                            @endif
                        </td>
                        <td class="button-group">
                            <div class="group-button-action">
                                <a href="{{ route('admin.event.detail', ['id' => $event->id, 'from' => 'history']) }}" class="btn-details" style="display: flex; align-items: center;">
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
        </div>
    </div>
@endsection
