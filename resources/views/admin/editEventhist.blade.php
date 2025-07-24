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

                @php
                    $isFinished = $event->finish_date < now();
                    $editableFields = [
                        'event_name' => $event->event_name,
                        'theme' => $event->theme,
                        'place' => $event->place,
                        'tenant_quota' => $event->tenant_quota,
                        'supported_electricity' => $event->supported_electricity,
                        'price_per_watt' => $event->price_per_watt,
                        'capital' => $event->capital,
                        'revenue' => $event->revenue,
                        'harga' => $event->harga,
                        'poster' => $event->poster,
                    ];
                    $hasEmptyField = collect($editableFields)->contains(function($val) {
                        return empty($val);
                    });
                @endphp

                @if(!$isFinished || ($isFinished && $hasEmptyField))
                <form action="{{ route('admin.event.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $event->id }}">
                    <input type="hidden" name="from" value="{{ request()->query('from') }}">
                    <div class="form-column-2">
                        <div class="form-group">
                            <label for="event_name">Event Name</label>
                            <input type="text" name="event_name" value="{{ $event->event_name }}" class="{{ $isFinished && !empty($event->event_name) ? 'readonly-style' : '' }}"
                                {{ $isFinished && !empty($event->event_name) ? 'readonly' : 'required' }}>
                        </div>

                        <div class="form-group">
                            <label for="theme">Event Theme</label>
                            <input type="text" name="theme" value="{{ $event->theme }}" class="{{ $isFinished && !empty($event->theme) ? 'readonly-style' : '' }}"
                                {{ $isFinished && !empty($event->theme) ? 'readonly' : 'required' }}>
                        </div>

                        <div class="form-group">
                            <label for="place">Place</label>
                            <input type="text" name="place" value="{{ $event->place }}" class="{{ $isFinished && !empty($event->place) ? 'readonly-style' : '' }}"
                                {{ $isFinished && !empty($event->place) ? 'readonly' : 'required' }}>
                        </div>

                        <div class="form-group">
                            <label for="tenant_quota">Tenant Quota</label>
                            <input type="number" name="tenant_quota" value="{{ $event->tenant_quota }}" min="0" class="{{ $isFinished && !empty($event->tenant_quota) ? 'readonly-style' : '' }}"
                                {{ $isFinished && !empty($event->tenant_quota) ? 'readonly' : 'required' }}>
                        </div>

                        <div class="form-group">
                            <label for="supported_electricity">Electricity Support (Ampere)</label>
                            <input type="number" name="supported_electricity" value="{{ $event->supported_electricity }}" min="0" class="{{ $isFinished && !empty($event->supported_electricity) ? 'readonly-style' : '' }}"
                                {{ $isFinished && !empty($event->supported_electricity) ? 'readonly' : 'required' }}>
                        </div>

                        <div class="form-group">
                            <label for="price_per_watt">Price per Watt</label>
                            <input type="number" name="price_per_watt" value="{{ $event->price_per_watt }}" min="0" class="{{ $isFinished && !empty($event->price_per_watt) ? 'readonly-style' : '' }}"
                                {{ $isFinished && !empty($event->price_per_watt) ? 'readonly' : '' }}>
                        </div>

                        <div class="form-group">
                            <label for="capital">Capital</label>
                            <input type="number" name="capital" value="{{ $event->capital }}" step="1000" min="0" class="{{ $isFinished && !empty($event->capital) ? 'readonly-style' : '' }}"
                                {{ $isFinished && !empty($event->capital) ? 'readonly' : 'required' }}>
                        </div>

                        <div class="form-group">
                            <label for="revenue">Revenue</label>
                            <input type="number" name="revenue" value="{{ $event->revenue }}" step="1000" min="0" class="{{ $isFinished && !empty($event->revenue) ? 'readonly-style' : '' }}"
                                {{ $isFinished && !empty($event->revenue) ? 'readonly' : '' }}>
                        </div>
                    </div>

                    <div class="form-row-4">
                        <div class="form-group">
                            <label for="harga">Booth Price</label>
                            <input type="number" name="harga" value="{{ $event->harga }}" min="0" class="{{ $isFinished && !empty($event->harga) ? 'readonly-style' : '' }}"
                                {{ $isFinished && !empty($event->harga) ? 'readonly' : '' }}>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" value="{{ $event->start_date }}" class="{{ $isFinished && !empty($event->start_date) ? 'readonly-style' : '' }}"
                                {{ $isFinished ? 'readonly' : 'required' }}>
                        </div>

                        <div class="form-group">
                            <label for="finish_date">Finish Date</label>
                            <input type="date" name="finish_date" value="{{ $event->finish_date }}" class="{{ $isFinished && !empty($event->finish_date) ? 'readonly-style' : '' }}"
                                {{ $isFinished ? 'readonly' : 'required' }}>
                        </div>

                        <div class="form-group">
                            <label for="poster">Poster</label>
                            @if($event->poster)
                                <div>
                                    <a href="{{ asset('storage/' . $event->poster) }}" target="_blank">
                                        {{ \Illuminate\Support\Str::limit(basename($event->poster), 30) }}
                                    </a>
                                </div>
                            @endif
                            @if($isFinished && !empty($event->poster))
                                <input type="file" name="poster" accept="image/*" disabled>
                            @else
                                <input type="file" name="poster" accept="image/*">
                            @endif
                        </div>
                    </div>

                    <div class="form-button-group">
                        <button type="submit" class="add-staff">
                            <span class="dropdown-icon material-symbols-outlined">edit</span>
                            Update
                        </button>
                        <a href="{{ route('dashboard.admin.eventhist') }}" class="add-staff btn-cancel">
                            <span class="material-symbols-outlined">close</span>
                            <span class="nav-label">Cancel</span>
                        </a>
                    </div>
                </form>
                @else
                    <div class="info">
                        Semua data telah lengkap dan event telah selesai. Tidak bisa diubah.
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
