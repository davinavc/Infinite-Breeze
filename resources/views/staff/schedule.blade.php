@extends('layouts.app-staff')

@section('title', 'Staff Infinite Breeze')

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
        <!-- Staff Commission Table -->
        <div class="staff-list">
                <h2>My Schedule</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Event Name</th>
                                <th>Selected Date</th>
                                <th>Place</th>
                                <th>Technical Meeting (TM)</th>
                                <th>TM Link</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($confirmed as $event_id => $items)
                                @php
                                    $first = $items->first(); // Ambil satu data untuk akses event
                                    $event = $first->jadwalStaff->event;
                                    $tanggalArray = $items->map(function ($item) {
                                        return \Carbon\Carbon::parse($item->jadwalStaff->tgl_event)->format('d-m');
                                    })->toArray();
                                    $tanggalGabung = implode(', ', $tanggalArray);
                                @endphp
                                <tr>
                                    <td>{{ $event->event_name }}</td>
                                    <td>{{ $tanggalGabung }}</td>
                                    <td>{{ $event->place }}</td>
                                    <td>{{ $event->tm ? \Carbon\Carbon::parse($event->tm)->format('d-m-Y') : '-' }}</td>
                                    <td>
                                        @php
                                            $tmLink = $event->tm_link;
                                            $isLink = filter_var($tmLink, FILTER_VALIDATE_URL);
                                        @endphp

                                        @if($isLink)
                                            <a href="{{ $tmLink }}" target="_blank" class="text-link">
                                                {{ $tmLink }}
                                            </a>
                                        @elseif($tmLink)
                                            <span>{{ $tmLink }}</span>
                                        @else
                                            <span>-</span>
                                        @endif
                                    </td>
                                    <td class="button-group">
                                        <div class="group-button-action">
                                            <a href="{{ route('staff.event.detail', ['id' => $first->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
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
            <div class="staff-list">
                <h2>Pending Schedule</h2>
                @if(session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Selected Date</th>
                            <th>Place</th>
                            <th>Status</th>
                            <th>Action</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pending as $p)
                            <tr>
                                <td>{{ $p->jadwalStaff->event->event_name}}</td>
                                <td>{{ ($p->jadwalStaff->tgl_event ? \Carbon\Carbon::parse($p->jadwalStaff->tgl_event)->format('d-m-Y') : '-') }}</td>
                                <td>{{ $p->jadwalStaff->event->place }}</td>
                                <td>{{ $p->status }}</td>
                                <td class="button-group">
                                    <div class="group-button-action">
                                        <form action="{{ route('register.cancel', $p->id) }}" method="POST">
                                            @csrf
                                            <button class="btn-cancel" onclick="return confirm('Batalkan pendaftaran?')">Cancel</button>
                                        </form>
                                    </div>
                                </td>
                                <td class="button-group">
                                    <div class="group-button-action">
                                        <a href="{{ route('staff.event.detail', ['id' => $p->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
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

            <div class="staff-list">
                <h2>Other Schedule (Rejected / Cancelled)</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Place</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($others as $o)
                            <tr>
                                <td>{{ $o->jadwalStaff->event->event_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($o->jadwalStaff->tgl_event)->format('d-m-Y') }}</td>
                                <td>{{ $o->jadwalStaff->event->place }}</td>
                                <td>{{ $o->status }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4">Tidak ada jadwal yang ditolak atau dibatalkan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>

@endsection