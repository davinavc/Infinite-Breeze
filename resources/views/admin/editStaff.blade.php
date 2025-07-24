@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Staff</h1>
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
                <h2>Data Staff</h2>
                @if(session('success'))
                    <div class="success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.staff.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $staff->id }}">
                    <div class="form-column-2">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ $staff->user->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_depan">Nama Depan</label>
                            <input type="text" name="nm_depan" value="{{ $staff->nm_depan }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_belakang">Nama Belakang</label>
                            <input type="text" name="nm_blkg" value="{{ $staff->nm_blkg }}">
                        </div>
                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" name="no_telp" value="{{ $staff->no_telp }}" required>
                            @error('no_telp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" required>{{ old('alamat', $staff->alamat) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Birth of Date</label>
                            <input type="date" name="birth_date" value="{{ $staff->birth_date }}" max="{{ date('Y-m-d', strtotime('-15 years')) }}" required>
                        </div>
                    </div>

                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="dpt_id">Departemen</label>
                            <select name="dpt_id" required>
                            @foreach ($departments as $dpt)
                                <option value="{{ $dpt->id }}" {{ $dpt->id == $staff->dpt_id ? 'selected' : '' }}>
                                    {{ $dpt->department }}
                                </option>
                            @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Position</label>
                            <select name="status" required>
                                @foreach (['Volunteer', 'Staff', 'Manager', 'Resign'] as $status)
                                    <option value="{{ $status }}" {{ $status == $staff->status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-button-group">
                        <button type="submit" class="add-staff">
                            <span class="dropdown-icon material-symbols-outlined">add</span>
                            Update
                        </button>
                        <a href="{{ route('dashboard.admin.staff') }}" class="add-staff btn-cancel">
                            <span class="material-symbols-outlined">close</span>
                            <span class="nav-label">Cancel</span>
                        </a>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

@endsection
