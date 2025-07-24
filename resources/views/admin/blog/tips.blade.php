@extends('layouts.app-blog')

@section('content')
    <main>
        <center><h2 class="upcoming-h2" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">TIPS</h2></center>

        <div class="container my-5 space-event" >
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse ($blogs as $blog)
                <div class="col" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="200">
                    <div class="card shadow">
                        @php
                            $header = $blog->images->where('image_type', 'header')->first();
                        @endphp     
                        @if($header)
                            <img src="{{ asset('storage/' . $header->image_path) }}" class="card-img-top" alt="Header Image">
                            <div class="card-body general">
                                <h5 class="card-title">{{ \Illuminate\Support\Str::limit($blog->title, 30) }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($blog->description, 130) }}</p>
                                <a class="card-text d-flex justify-content-end read-more" href="">Read More <span class="material-symbols-outlined">arrow_forward</span></a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Tanggal: {{ \Carbon\Carbon::parse($blog->created_at)->translatedFormat('d F Y') }}</small>
                            </div>
                        @else
                            <div class="card-body news">
                                <h5 class="card-title">{{ \Illuminate\Support\Str::limit($blog->title, 30) }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($blog->description, 130) }}</p>
                                <a class="card-text d-flex justify-content-end read-more" href="">Read More <span class="material-symbols-outlined">arrow_forward</span></a>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Tanggal: {{ \Carbon\Carbon::parse($blog->created_at)->translatedFormat('d F Y') }}</small>
                            </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-12" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="200">
                    <center><p>NO BLOG WITH CATEGORY 'TIPS'</p></center>
                </div>
                @endforelse
            </div>
        </div>
    </main>

@endsection
