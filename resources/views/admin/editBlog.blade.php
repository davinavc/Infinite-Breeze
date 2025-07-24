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
            <form action="{{ route('admin.blog.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $blog->id }}">
                <div class="form-column-2">
                    <div class="form-group">
                        <label for="category">Kategori:</label>
                        <select name="category" id="category" value="{{ $blog->category }}" required>
                            <option value="News" {{ $blog->category == 'News' ? 'selected' : '' }}>News</option>
                            <option value="Event" {{ $blog->category == 'Event' ? 'selected' : '' }}>Event</option>
                            <option value="Tips" {{ $blog->category == 'Tips' ? 'selected' : '' }}>Tips</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="event_id">Pilih Event:</label>
                        <select name="event_id" id="event_id">
                            <option value="">-- Pilih Event --</option>
                            @foreach ($events as $event)
                                <option value="{{ $event->id }}" {{ $event->id == $blog->event_id ? 'selected' : '' }} >{{ $event->event_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-column-1">
                    <div class="form-group">
                        <label for="judul_blog">Judul Blog:</label>
                        <input type="text" name="judul_blog" id="judul_blog" value="{{ $blog->title }}" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi_blog">Deskripsi Blog:</label>
                        <textarea name="deskripsi_blog" id="deskripsi_blog" rows="3" required>{{ $blog->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="content">Isi Konten Blog:</label>
                        <textarea name="content" id="content" rows="6"  required>{{ $blog->content}}</textarea>
                    </div>
                </div>
                <div class="form-column-2">
                    @if ($headerImage)
                        <div class="blog-group">
                            <label>Gambar Header Saat Ini:</label>
                            <a href="{{ asset('storage/' . $headerImage->image_path) }}" target="_blank">
                                {{ \Illuminate\Support\Str::limit(basename($headerImage->image_path), 40) }}
                            </a>                            
                            <div>
                                <label>
                                    <input class="blog-checkbox1" type="checkbox" name="delete_header" value="1"> 
                                    Hapus gambar header ini
                                </label>
                            </div>
                        </div>
                    @else 
                        <div class="blog-group">
                            <label for="images">Upload Gambar Header Blog:</label>
                            <input type="file" name="header_image" id="header_image" accept="image/*">
                        </div>
                    @endif

                    @if ($contentImages->isNotEmpty())
                        <div class="blog-group">
                            <label>Gambar Konten Saat Ini:</label>
                            @foreach ($blog->images->where('image_type', 'content') as $img)
                                <div style="margin-bottom:10px;">
                                    <a href="{{ asset('storage/' . $img->image_path) }}" target="_blank">
                                        {{ \Illuminate\Support\Str::limit(basename($img->image_path), 40) }}
                                    </a>                                      
                                    <div>
                                        <label style="display:flex;align-items:center;">
                                            <input class="blog-checkbox1" type="checkbox" name="delete_content_images[]" value="{{ $img->id }}"> 
                                            Hapus gambar ini
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else 
                        <div class="blog-group">
                            <label for="images">Upload Gambar Konten Blog:</label>
                            <input type="file" name="content_images[]" id="content_images" multiple accept="image/*">
                        </div>
                    @endif
                </div>

                <div class="form-button-group">
                    @if ($blog->status == 'Draft')
                        <button type="submit" name="action" value="Draft" class="add-staff">
                            <span class="dropdown-icon material-symbols-outlined">draft</span> Save
                        </button>
                        <button type="submit" name="action" value="Published" class="add-staff">
                            <span class="dropdown-icon material-symbols-outlined">publish</span> Publish
                        </button>
                    @elseif ($blog->status == 'Published')
                        <button type="submit" name="action" value="Archived" class="add-staff">
                            <span class="dropdown-icon material-symbols-outlined">unarchive</span> Archive
                        </button>
                    @elseif ($blog->status == 'Archived')
                        <button type="submit" name="action" value="Published" class="add-staff">
                            <span class="dropdown-icon material-symbols-outlined">unarchive</span> Re-Publish
                        </button>
                    @endif
                    <a href="{{ route('dashboard.admin.blog') }}" class="add-staff btn-cancel">
                        <span class="material-symbols-outlined">close</span> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
@endsection
