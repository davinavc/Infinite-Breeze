@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Department</h1>
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
                <h2>List Department</h2>

                @if(session('success'))
                    <div class="success">{{ session('success') }}</div>
                @endif

                <a href="{{ route('dashboard.admin.adddept') }}" class="add-staff">
                    <span class="dropdown-icon material-symbols-outlined">add</span>
                    Add Department
                </a>
                <table>
                    <thead>
                        <tr>
                            <th>Department Id</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($deptList as $dept)
                        <tr>
                            <td>{{ $dept->id }}</td>
                            <td>{{ $dept->department }}</td>
                            <td>{{ $dept->status }}</td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    <a href="{{ route('department.edit', $dept->id) }}" class="btn-edit" style="display: flex; align-items: center;">
                                        <span class="material-symbols-outlined">edit</span>
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.dept.toggle', $dept->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengubah status department ini?');">
                                        @csrf
                                        <button type="submit" class="btn-toggle">
                                            {{ $dept->status === 'Active' ? 'Inactive' : 'Active' }}                                 
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Tidak ada data department.</td>
                        </tr>
                    @endforelse

                    </tbody>
                </table>

            </div>
        </div>
    </div>
@endsection