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
            <h2>Verify  Schedule</h2>
            <a href="" class="add-staff-inactive">
                <span class="dropdown-icon material-symbols-outlined">verified_user</span>
                Verify
            </a>
            <a href="{{ route('dashboard.admin.viewschedule') }}" class="add-staff" style="gap:5px">
                <span class="dropdown-icon material-symbols-outlined">visibility</span>
                View
            </a>
            <a href="{{ route('dashboard.admin.addschedule') }}" class="add-staff">
                <span class="dropdown-icon material-symbols-outlined">add</span>
                Add
            </a>
            <table class="table">
                <thead>
                    <tr>
                        <th>Staff Name</th>
                        <th>Event Name</th>
                        <th>Selected Date</th>
                        <th>Staff Slot</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($regist as $jadwal)
                    <tr>
                        <td>{{ $jadwal->staff->nm_depan }} {{ $jadwal->staff->nm_blkg }}</td>
                        <td>{{ $jadwal->jadwalStaff->event->event_name }}</td>
                        <td>{{ $jadwal->jadwalStaff->tgl_event ? \Carbon\Carbon::parse($jadwal->jadwalStaff->tgl_event)->format('d-m-Y') : '-' }}</td>
                        <td>{{ $jadwal->jadwalStaff->maks_staff }}</td>
                        <td class="button-group">
                            <div class="group-button-action">
                                <form action="{{ route('admin.schedule.accept', $jadwal->id) }}" method="POST">
                                    @csrf
                                    <button class="btn-edit" onclick="return confirm('Terima registrasi ini?')">
                                        <span class="material-symbols-outlined">check_circle</span>
                                        Accept
                                    </button>
                                </form>
                                <form action="{{ route('admin.schedule.reject', $jadwal->id) }}" method="POST">
                                    @csrf
                                    <button class="btn-cancel" onclick="return confirm('Tolak registrasi ini?')">
                                        <span class="material-symbols-outlined">close</span>
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
