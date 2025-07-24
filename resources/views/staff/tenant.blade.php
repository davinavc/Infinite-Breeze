@extends('layouts.app-staff')

@section('title', 'Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Tenant</h1>
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
            <h2>List Tenant</h2>
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            <table>
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Tenant Name</th>
                        <th>Phone Number</th>
                        <th>Category</th>
                        <th>Follow Up</th>
                        <th>Follow Up By</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($transaksiAktif as $transaksi)
                    <tr>
                        <td>{{ $transaksi->event->event_name ?? '-'}} </td>
                        <td>{{ $transaksi->tenant->tenant_name }} </td>
                        <td>{{ $transaksi->tenant->user->no_telp }}</td>
                        <td>{{ $transaksi->tenant->category_name }} </td>
                        <td>
                            @if($transaksi->follow_up_by)
                                <span class="material-symbols-outlined success" style="margin-top:5px;">check</span>
                            @else
                                <span class="material-symbols-outlined text-danger">close</span>
                            @endif
                        </td>
                        <td>
                            @if($transaksi->staffFollowUp)
                                {{ $transaksi->staffFollowUp->nm_depan }} {{ $transaksi->staffFollowUp->nm_blkg }}
                            @else
                                -
                            @endif

                        </td>
                        <td class="button-group">
                            <div class="group-button-action">
                                <button type="button"
                                    class="btn-edit follow-up-btn"
                                    data-id="{{ $transaksi->id }}"
                                    data-email="{{ $transaksi->tenant->user->email }}">
                                    <span class="material-symbols-outlined">account_box</span>
                                    Follow Up
                                </button>
                            </div>                
                        </td>
                        <td class="button-group">
                            <div class="group-button-action">
                                <a href="{{ route('admin.tenant.detail', ['id' => $transaksi->tenant->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                    <span class="material-symbols-outlined">info</span>
                                        Details
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">Tidak ada data Tenant.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
