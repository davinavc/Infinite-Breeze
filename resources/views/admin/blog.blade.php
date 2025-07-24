@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Blog</h1>
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
        <!-- Department Table -->
        <div class="staff-list">
            <h2>List Blog</h2>
            @if(session('success'))
                <div class="success">{{ session('success') }}</div>
            @endif
            <a href="{{ route('dashboard.admin.addblog') }}" class="add-staff">
                <span class="dropdown-icon material-symbols-outlined">add</span>
                Add Blog
            </a>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blog as $blg)
                        <tr>
                            <td>{{ $blg->title }}</td>
                            <td>{{ $blg->category}}</td>
                            <td>{{ ($blg->created_at) ? \Carbon\Carbon::parse($blg->created_at)->format('d-m-Y') : '' }}</td>
                            <td>{{ $blg->status }}</td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    <a href="{{ route('admin.blog.edit', ['id' => $blg->id, 'from' => 'blog']) }}" class="btn-edit" style="display: flex; align-items: center;">
                                        <span class="material-symbols-outlined">edit</span>
                                        Edit
                                    </a>
                                </div>
                            </td>
                            <td class="button-group">
                                <div class="group-button-action">
                                    <a href="{{ route('admin.blog.detail', ['id' => $blg->id, 'from' => 'active']) }}" class="btn-details" style="display: flex; align-items: center;">
                                        <span class="material-symbols-outlined">info</span>
                                            Details
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">Tidak ada data blog.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
