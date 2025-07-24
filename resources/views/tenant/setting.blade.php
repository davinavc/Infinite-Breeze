@extends('layouts.app-tenant')

@section('title', 'Infinite Breeze')

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

                <form action="{{ route('tenant.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $tenant->id }}">
                    <div class="form-column-2">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" value="{{ $tenant->user->email }}" required>
                        </div>

                        <div class="form-group">
                            <label for="tenant_name">Brand Name</label>
                            <input type="text" name="tenant_name" value="{{ $tenant->tenant_name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="category_name">Brand Category</label>
                            <input type="text" name="category_name" value="{{ $tenant->category_name }}">
                        </div>
                        <div class="form-group">
                            <label>No Telepon</label>
                            <input type="text" name="no_telp" value="{{ $tenant->user->no_telp }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_bank">Bank</label>
                            <input type="text" name="nama_bank" value="{{ $tenant->nama_bank }}" required>
                        </div>
                        <div class="form-group">
                            <label for="rekening">Rekening</label>
                            <input type="text" name="rekening" value="{{ $tenant->rekening }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" required>{{ old('alamat', $tenant->alamat) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="logo">logo</label>
                            @if($tenant->logo)
                                <div>
                                    <a href="{{ asset('storage/' . $tenant->logo) }}" target="_blank">
                                        {{ \Illuminate\Support\Str::limit(basename($tenant->logo), 30) }}
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="logo" value="{{ $tenant->logo }}" accept="image/*">
                        </div> 
                        
                    </div>

                    <div class="form-button-group">
                        <button type="submit" class="add-staff">
                            <span class="dropdown-icon material-symbols-outlined">edit</span>
                            Update
                        </button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>

@endsection
