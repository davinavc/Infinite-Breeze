@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>History Staff</h1>
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
        <!-- List Department Table -->
        <div class="staff-list">
            <h2>List Staff</h2>
            <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Departemen</th>
                <th>Join Date</th>
                <th>Exit Date</th>
                <th>Details</th>

            </tr>
        </thead>
        <tbody>
            @forelse($resignedStaff as $staff)
                <tr>
                    <td>{{ $staff->nm_depan }} {{ $staff->nm_blkg }}</td>
                    <td>{{ $staff->user->email }}</td>
                    <td>{{ $staff->departemen->department ?? '-' }}</td>
                    <td>{{ $staff->created_at->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $staff->tgl_exit ? \Carbon\Carbon::parse($staff->tgl_exit)->format('d-m-Y') : '-' }}</td>
                    <td class="button-group">
                        <div class="group-button-action">
                            <a href="{{ route('admin.staff.detail', ['id' => $staff->id, 'from' => 'history']) }}" class="btn-details" style="display: flex; align-items: center;">
                                 <span class="material-symbols-outlined">info</span>
                                    Details
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Tidak ada data staff resign.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

        </div>
    </div>
@endsection