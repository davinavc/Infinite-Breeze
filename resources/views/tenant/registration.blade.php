@extends('layouts.app-tenant')

@section('title', 'Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Registered Event</h1>
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
            <h2>Event yang Anda Daftarkan</h2>
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="text-danger">{{ session('error') }}</div>
            @endif
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Theme</th>
                        <th>Date</th>
                        <th>Place</th>
                        <th>Status Regist</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                        @php
                            $event = $reg->event;
                            $status = $reg->status;
                        @endphp
                        <tr>
                            <td>{{ $event->event_name }}</td>
                            <td>{{ $event->theme }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') }} - 
                                {{ \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') }}
                            </td>
                            <td>{{ $event->place }}</td>
                            <td>{{ ucfirst($status) }}</td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    @if($status === 'Pending')
                                        <form action="{{ route('tenant.registration.cancel', $reg->id) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pendaftaran ini?')">
                                            @csrf
                                            <button class="add-staff btn-cancel">
                                                <span class="material-symbols-outlined">close</span>
                                                Cancel
                                            </button>
                                        </form>
                                    @elseif($status === 'Confirmed')
                                        <a href="{{ route('dashboard.tenant.transaction') }}" class="btn-edit" style="display: flex; align-items: center;">
                                            Continue
                                            <span class="material-symbols-outlined">arrow_forward</span>
                                        </a>
                                    @elseif($status === 'Rejected')
                                        <span class="text-danger">Rejected</span>
                                    @endif
                                </div>
                            </td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    <a href="{{ route('tenant.event.detail', ['id' => $event->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                        <span class="material-symbols-outlined">info</span>
                                            Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">Belum ada pendaftaran event.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
