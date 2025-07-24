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

                <form action="{{ route('admin.staff.store') }}" method="POST">
                    @csrf
                    <div class="form-column-2">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" placeholder="Email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_depan">Nama Depan</label>
                            <input type="text" name="nm_depan" id="nama_depan" required>
                        </div>

                        <div class="form-group">
                            <label for="nama_belakang">Nama Belakang</label>
                            <input type="text" name="nm_blkg" id="nama_belakang">
                        </div>
                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" name="no_telp" required>
                            @error('no_telp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kode Referral</label>
                            <input type="text" name="referral_code" style="text-transform: uppercase;" required>
                        </div>
                    </div>
                    <div class="form-column-1">
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" id="alamat" required></textarea>
                        </div>
                    </div>
                    <div class="form-row-3">
                        <div class="form-group">
                            <label for="tanggal_lahir">Birth of Date</label>
                            <input type="date" name="birth_date" id="tanggal_lahir" max="{{ date('Y-m-d', strtotime('-15 years')) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="dpt_id">Departemen</label>
                            <select name="dpt_id" required>
                                <option value=""  disabled selected>-- Pilih Departemen --</option>
                                @foreach ($departments as $dpt)
                                    <option value="{{ $dpt->id }}">{{ $dpt->department }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="status">Position</label>
                            <select name="status" required>
                                <option value="" disabled selected>-- Pilih Status --</option>
                                <option value="Volunteer">Volunteer</option>
                                <option value="Staff">Staff</option>
                                <option value="Manager">Manager</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-button-group">
                        <button type="submit" class="add-staff">
                            <span class="dropdown-icon material-symbols-outlined">add</span>
                            Create
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
