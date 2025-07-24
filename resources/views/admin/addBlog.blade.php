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
            <h2>Data Blog</h2>
            @if(session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif
            <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-column-2">
                    <div class="form-group">
                        <label for="category">Kategori:</label>
                        <select name="category" id="category" required>
                            <option value="News">News</option>
                            <option value="Event">Event</option>
                            <option value="Tips">Tips</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="event_id">Pilih Event:</label>
                        <select name="event_id" id="event_id" disabled>
                            <option value="">-- Pilih Event --</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}" >{{ $event->event_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-column-1">
                    <div class="form-group">
                        <label for="judul_blog">Judul Blog:</label>
                        <input type="text" name="judul_blog" id="judul_blog" required>
                    </div>

                    <div class="form-group">
                        <label for="deskripsi_blog">Deskripsi Blog:</label>
                        <textarea name="deskripsi_blog" id="deskripsi_blog" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="content">Isi Konten Blog:</label>
                        <textarea name="content" id="content" rows="6" required></textarea>
                    </div>
                </div>
                <div class="form-column-2">
                    <div class="form-group">
                        <label for="images">Upload Gambar Header Blog:</label>
                        <input type="file" name="header_image" id="header_image" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label for="images">Upload Gambar Konten Blog:</label>
                        <input type="file" name="content_images[]" id="content_images" multiple accept="image/*">
                    </div>
                </div>

                <div class="form-button-group">
                    <button type="submit" name="action" value="Draft" class="add-staff">
                        <span class="dropdown-icon material-symbols-outlined">draft</span> Draft
                    </button>
                    <button type="submit" name="action" value="Published" class="add-staff">
                        <span class="dropdown-icon material-symbols-outlined">publish</span> Publish
                    </button>
                    <a href="{{ route('dashboard.admin.blog') }}" class="add-staff btn-cancel">
                        <span class="material-symbols-outlined">close</span> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
