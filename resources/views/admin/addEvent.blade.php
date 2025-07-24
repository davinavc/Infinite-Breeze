@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Event</h1>
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
                <h2>Data Event</h2>
                @if(session('success'))
                    <div class="success">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-column-2">
                        <div class="form-group">
                            <label for="event_name">Event Name</label>
                            <input type="text" name="event_name" id="event_name" required>
                        </div>

                        <div class="form-group">
                            <label for="theme">Event Theme</label>
                            <input type="text" name="theme" id="theme" required>
                        </div>

                        <div class="form-group">
                            <label for="place">Place</label>
                            <input type="text" name="place" id="place" required>
                        </div>

                        <div class="form-group">
                            <label for="tenant_quota">Tenant Quota</label>
                            <input type="number" name="tenant_quota" id="tenant_quota" min="0" required>
                        </div>

                        <div class="form-group">
                            <label for="supported_electricity">Electricity Support (Ampere)</label>
                            <input type="number" name="supported_electricity" id="supported_electricity" min="0" required>
                        </div>

                        <div class="form-group">
                            <label for="price_per_watt">Price per Watt</label>
                            <input type="number" name="price_per_watt" id="price_per_watt"  min="0">
                        </div>

                        <div class="form-group">
                            <label for="tm">Technical Meeting Date</label>
                            <input type="date" name="tm" id="tm">
                        </div>

                        <div class="form-group">
                            <label for="tm_link">Technical Meeting Link</label>
                            <input type="text" name="tm_link" id="tm_link">
                        </div>

                        <div class="form-group">
                            <label for="capital">Capital</label>
                            <input type="number" name="capital" id="capital" step="1000" min="0" required>
                        </div>

                        <div class="form-group">
                            <label for="revenue">Revenue</label>
                            <input type="number" name="revenue" id="revenue" step="1000" min="0" >
                        </div>
                    </div>

                    <div class="form-row-4">
                        <div class="form-group">
                            <label for="harga">Booth Price</label>
                            <input type="number" name="harga" id="harga" min="0" >
                        </div>
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" required>
                        </div>

                        <div class="form-group">
                            <label for="finish_date">Finish Date</label>
                            <input type="date" name="finish_date" id="finish_date" required>
                        </div>

                        <div class="form-group">
                            <label for="poster">Poster</label>
                            <input type="file" name="poster" id="poster" accept="image/*">
                        </div> 
                    </div>

                    <div class="form-button-group">
                        <button type="submit" class="add-staff">
                            <span class="dropdown-icon material-symbols-outlined">add</span>
                            Create
                        </button>
                        <a href="{{ route('dashboard.admin.event') }}" class="add-staff btn-cancel">
                            <span class="material-symbols-outlined">close</span>
                            <span class="nav-label">Cancel</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
