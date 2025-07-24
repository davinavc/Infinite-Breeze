@extends('layouts.app-staff')

@section('title', 'Staff Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Event {{ $jadwalList->first()->event->event_name ?? '-' }}</h1>
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
            <h2>Register Event</h2>
            <a href="{{ route('dashboard.staff.event') }}" class="btn-back add-staff" style="margin-bottom:10px;">
                <span class="material-symbols-outlined">chevron_left</span>          
                <span class="nav-label">Back</span>
            </a>
                @if(session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Slot</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwalList as $jadwal)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($jadwal->tgl_event)->format('d-m-Y') }}</td>
                                <td>{{ $jadwal->accepted_count }}/{{ $jadwal->maks_staff }}</td>
                                <td class="button-group">
                                    <div class="group-button-action">
                                        @php
                                            $staffId = auth()->user()->staff->id;
                                            $registrasi = $jadwal->registrasi->where('staff_id', $staffId)->first();
                                        @endphp

                                        @if($registrasi)
                                            @if($registrasi->status == 'Confirmed')
                                                <span class="success">Registered</span>
                                            @elseif($registrasi->status == 'Pending')
                                                <span>Pending</span>
                                            @elseif($registrasi->status == 'Rejected')
                                                <span class="text-danger">Rejected</span>
                                            @elseif($registrasi->status == 'Cancel')
                                                <form method="POST" action="{{ route('register.schedule', ['jadwal_id' => $jadwal->id]) }}">
                                                    @csrf
                                                    <button type="submit" class="btn-register" onclick="return confirm('Apakah Anda yakin ingin mendaftar lagi pada tanggal ini?')">
                                                        <span class="material-symbols-outlined">checkbook</span>
                                                        Register
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            @if($jadwal->accepted_count < $jadwal->maks_staff)
                                                <form method="POST" action="{{ route('register.schedule', ['jadwal_id' => $jadwal->id]) }}">
                                                    @csrf
                                                    <button type="submit" class="btn-register" onclick="return confirm('Apakah Anda yakin ingin mendaftar pada tanggal ini?')">
                                                        <span class="material-symbols-outlined">checkbook</span>
                                                        Register
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-danger">Penuh</span>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Tidak ada data event.</td>
                            </tr>
                        @endforelse
                    </tbody>    
                </table>
            </div>
        </div>
        </div>
    </div>

@endsection