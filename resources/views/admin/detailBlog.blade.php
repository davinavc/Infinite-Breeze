@extends('layouts.app-admin')

@section('title', 'Admin Infinite Breeze')

@section('content')
    <header class="content-header">
        <h1>Detail Blog</h1>
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
        <div class="staff-list">
            
            <a href="{{ route('dashboard.admin.blog') }}" class="btn-back add-staff">
                <span class="material-symbols-outlined">chevron_left</span>          
                <span class="nav-label">Back</span>
            </a>
            <div class="details-data">
                <b><p style="font-size:36px;text-align:center;text-decoration:bold;">{{ $blog->title }}</p></b>
                <div class="header-blog">
                    @if($headerImage)
                        <img src="{{ asset('storage/' . $headerImage->image_path) }}" alt="Header Image">
                    @else
                        <p><em>No header image uploaded.</em></p>
                    @endif
                </div>
                
                
                <p><strong>Content:</strong> {{ $blog->category }}</p>
                <p><strong>Description</strong><br>{{ $blog->description }}</p>
                <p><strong>Content</strong></p>
                {!! $blog->content !!}
                <p><strong>Created Date:</strong> {{ $blog->created_at ? \Carbon\Carbon::parse($blog->created_at)->format('d-m-Y') : ' - ' }}</p>
                <p><strong>Update Date:</strong> {{ $blog->upated_at ? \Carbon\Carbon::parse($blog->upated_at)->format('d-m-Y') : ' - ' }}</p>
            </div>
        </div>
        
    </div>
@endsection