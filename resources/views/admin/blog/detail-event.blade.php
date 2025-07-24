@extends('layouts.app-blog')

@section('content')
    <center>
        <h2 class="upcoming-h2 space-detail-event" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">
            {{ $blog->title }}
        </h2>
    </center>

    <div class="container my-5 space-detail-event">
        <div class="row row-cols-1 ">
            <div class="col" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="200">
                @php
                    $header = $blog->images->where('image_type', 'header')->first();
                    $imgcontent = $blog->images->where('image_type', 'content')->first();
                @endphp     

                @if($header)
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('storage/' . $header->image_path) }}" class="detail-img" alt="Header Image">
                    </div>
                @endif

                <div class="">
                    <h5 class="sub-title">{{ $blog->title }}</h5>
                    <p class=" d-flex align-items-center mb-1">{!! nl2br(e($blog->content)) !!}</p>

                    @if($imgcontent)
                        <img src="{{ asset('storage/' . $imgcontent->image_path) }}" alt="" class="detail-img">
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
