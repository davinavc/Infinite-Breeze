@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@php
    use Illuminate\Support\Str;
@endphp

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
            <h2>List Event</h2>
                @if(session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif
                <a href="{{ route('dashboard.admin.addevent') }}" class="add-staff">
                    <span class="dropdown-icon material-symbols-outlined">add</span>
                    Add Event
                </a>
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Event Date</th>
                            <th>Place</th>
                            <th>Status</th>
                            <th>Booth Price</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                            <tr>                                
                                <td>{{ $event->event_name}}</td>
                                <td>{{ ($event->start_date && $event->finish_date) ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') . ' - ' . \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : '-'}}</td>
                                <td>{{ Str::limit($event->place, 35, '...') }}</td>
                                <td>{{ $event->status }}</td>
                                <td>Rp {{ number_format($event->harga, 0, ',', '.') }}</td>
                                <td class="button-group">
                                    <div class="group-button-action">
                                        <a href="{{ route('admin.event.edit', ['id' => $event->id, 'from' => 'event']) }}" class="btn-edit" style="margin-bottom:10px;">
                                            <span class="material-symbols-outlined">edit</span>
                                            Edit
                                        </a>
                                    </div>
                                    <form action="{{ route('event.sendReminder', $event->id) }}" method="POST">
                                        @csrf
                                        <div class="group-button-action">
                                            <button type="submit" class="btn-edit" style="margin-bottom:10px">
                                                <span class="material-symbols-outlined">share</span>Share
                                            </button>
                                        </div>
                                    </form>

                                </td>
                                <td class="button-group">
                                    <div class="group-button-action">
                                        <a href="{{ route('admin.event.detail', ['id' => $event->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
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