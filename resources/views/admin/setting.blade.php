@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Setting</h1>
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
                <h2>Data</h2>
                @if(session('success'))
                    <div class="success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.setting.update', ['id' => $admin->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $admin->id }}">
                    <div class="form-column-1">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ $admin->email }}" required>
                        </div>
                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" name="no_telp" value="{{ $admin->no_telp }}" required>
                            @error('no_telp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    <div class="form-button-group">
                        <button type="submit" class="add-staff">
                            <span class="dropdown-icon material-symbols-outlined">add</span>
                            Update
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

@endsection
