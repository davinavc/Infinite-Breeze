@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Registration</h1>
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
            <h2>Verify Registration</h2>
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            <a href="{{ route('dashboard.admin.registration') }}" class="add-staff-inactive">
                <span class="dropdown-icon material-symbols-outlined">verified_user</span>
                Verify
            </a>
            <a href="{{ route('dashboard.admin.viewregist') }}" class="add-staff" style="gap:5px">
                <span class="dropdown-icon material-symbols-outlined">visibility</span>
                View
            </a>
            <table>
                <thead>
                    <tr>
                        <th>Tenant Name</th>
                        <th>Category Tenant</th>
                        <th>Event Name</th>
                        <th>Theme</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                        @php
                            $event = $reg->event;
                            $tenant = $reg->tenant;
                            $status = $reg->status;
                        @endphp
                        <tr>
                            <td>{{ $tenant->tenant_name }}</td>
                            <td>{{ $tenant->category_name }}</td>
                            <td>{{ $event->event_name }}</td>
                            <td>{{ $event->theme }}</td>
                            <td>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') }} - 
                                {{ \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') }}
                            </td>
                            <td>{{ ucfirst($status) }}</td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    <form action="{{ route('admin.registration.accept', $reg->id) }}" method="POST">
                                        @csrf
                                        <button class="btn-edit" onclick="return confirm('Terima registrasi ini?')">
                                            <span class="material-symbols-outlined">check_circle</span>
                                            Accept
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.registration.reject', $reg->id) }}" method="POST">
                                        @csrf
                                        <button class="btn-cancel" onclick="return confirm('Tolak registrasi ini?')">
                                            <span class="material-symbols-outlined">close</span>
                                            Reject
                                        </button>
                                    </form>
                                
                                </div>
                            </td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    <a href="{{ route('admin.regist.detail', ['id' => $reg->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                        <span class="material-symbols-outlined">info</span>
                                            Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9">Belum ada pendaftaran event.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
