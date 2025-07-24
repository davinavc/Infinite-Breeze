@extends('layouts.app-blog')

@section('content')

<head>
    <link rel="stylesheet" href="owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" href="owlcarousel/owl.theme.default.min.css">

</head>

    <!-- {{-- EVENT CAROUSEL --}}

    <section id="event" class="py-10 bg-gray-100">
        <h2 class="text-2xl font-bold text-center mb-6">Upcoming Events</h2>

        <div class="swiper-container px-4">
            <div class="swiper-wrapper">
                @foreach ($events as $event)
                    <div class="swiper-slide bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="{{ $event->poster }}" alt="Event Image" class="h-64 w-full object-cover">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold">{{ $event->name }}</h3>
                            <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') }}</p>
                            <a href="{{ route('blog.show', $event->id) }}" class="text-blue-600">Check More Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>  -->

            <!-- Navigasi panah -->
            <!-- <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div> -->

            <!-- Pagination -->
            <!-- <div class="swiper-pagination mt-4"></div>
        </div>
    </section> -->

    <main>
        @if ($events->count() > 0)
        <div id="carouselEvent" class="carousel slide mx-auto mt-5" data-bs-ride="carousel" data-bs-interval="4000" style="max-width: 300px;">

            {{-- INDICATORS --}}
            @if ($events->count() > 1)
            <div class="carousel-indicators">
                @foreach ($events as $index => $event)
                    <button type="button" data-bs-target="#carouselEvent" data-bs-slide-to="{{ $index }}"
                        class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-label="Slide {{ $index + 1 }}"></button>
                @endforeach
            </div>
            @endif

            {{-- SLIDES --}}
            <div class="carousel-inner">
                @foreach ($events as $index => $event)
                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $event->poster) }}" class="d-block w-100 rounded carousel-img"
                        alt="Event {{ $index + 1 }}">


                    <div class="carousel-caption d-none d-md-block bg-light rounded" style="--bs-bg-opacity: 0;">
                        <a href=""><u>Check More Detail -></u></a>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- CONTROLS --}}
            @if ($events->count() > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselEvent" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselEvent" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            @endif
        </div>
        @endif


        {{-- NEWS SECTION --}}

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 welcome">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="font-semibold big-size" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="200">NEWS</h2>
                <a href="{{ route('blog.news') }}" class="btn-detail font-semibold d-flex align-items-center mb-1">Check More Detail<span class="material-symbols-outlined">arrow_forward</span></a>
            </div>
            <div class="container my-5" >
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @forelse ($news as $n)
                        <div class="col" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="200">
                            <div class="card shadow">
                                @php
                                    $header = $n->images->where('image_type', 'header')->first();
                                @endphp     
                                @if($header)
                                    <img src="{{ asset('storage/' . $header->image_path) }}" class="card-img-top" alt="Header Image">
                                @endif
                                <div class="card-body news">
                                    <h5 class="card-title">{{ $n->title }}</h5>
                                    <p class="card-text d-flex align-items-center mb-1" >
                                        {{ \Illuminate\Support\Str::limit($n->description, 130) }}</p>
                                    <a class="card-text d-flex justify-content-end read-more" href="{{ route('blog.detailnews', $n->id) }}">Read More <span class="material-symbols-outlined">arrow_forward</span></a>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Tanggal: {{ \Carbon\Carbon::parse($n->created_at)->translatedFormat('d F Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="col-center" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="200">Belum ada event yang akan datang.</p>
                        </div>
                        @endforelse
                    </div>
            </div>
        </section>

        {{-- Upcoming SECTION --}}
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 welcome">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="font-semibold big-size" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="200">UPCOMING EVENT</h2>
                <a href="{{ route('blog.event') }}" class="btn-detail font-semibold d-flex align-items-center mb-1">Check More Detail<span class="material-symbols-outlined">arrow_forward</span></a>
            </div>
            <div class="container my-5" >
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @forelse ($upcomingEvents as $e)
                        <div class="col" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="200">
                            <div class="card shadow">
                                @if($e->poster)
                                    <img src="{{ asset('storage/' . $e->poster) }}" class="card-img-top" alt="Event Poster">
                                @endif
                                <div class="card-body general">
                                    <h5 class="card-title">{{ $e->event_name }}</h5>
                                    <p class="card-text d-flex align-items-center mb-1" ><span class="material-symbols-outlined me-2">calendar_month</span>
                                        {{ \Illuminate\Support\Str::limit($e->start_date, 100) }}</p>
                                    <p class="card-text card-text d-flex align-items-center mb-2"><span class="material-symbols-outlined me-2">distance</span>
                                        {{ \Illuminate\Support\Str::limit($e->place, 30) }}</p>
                                    <a class="card-text d-flex justify-content-end read-more" href="{{ route('blog.detailupcoming', $e->id) }}">Read More <span class="material-symbols-outlined">arrow_forward</span></a>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Tanggal: {{ \Carbon\Carbon::parse($e->created_at)->translatedFormat('d F Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="text-center">Belum ada event yang akan datang.</p>
                        </div>
                        @endforelse
                    </div>
            </div>
        </section>

        {{-- EVENT SECTION --}}

        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 welcome">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="font-semibold big-size" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="200">EVENT</h2>
                <a href="{{ route('blog.event') }}" class="btn-detail font-semibold d-flex align-items-center mb-1">Check More Detail<span class="material-symbols-outlined">arrow_forward</span></a>
            </div>
            <div class="container my-5" >
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @forelse ($highlight as $h)
                        <div class="col" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="200">
                            <div class="card shadow">
                                @php
                                    $header = $h->images->where('image_type', 'header')->first();
                                @endphp     
                                @if($header)
                                    <img src="{{ asset('storage/' . $header->image_path) }}" class="card-img-top" alt="Header Image">
                                @endif
                                <div class="card-body general">
                                    <h5 class="card-title">{{ $h->title }}</h5>
                                    <p class="card-text d-flex align-items-center mb-1" >
                                        {{ \Illuminate\Support\Str::limit($h->description, 70) }}</p>
                                    <a class="card-text d-flex justify-content-end read-more" href="{{ route('blog.detailevent', $h->id) }}">Read More <span class="material-symbols-outlined">arrow_forward</span></a>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Tanggal: {{ \Carbon\Carbon::parse($h->created_at)->translatedFormat('d F Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <p class="text-center">Belum ada event yang akan datang.</p>
                        </div>
                        @endforelse
                    </div>
            </div>
        </section>
    </main>

    <!--
    <script>
        const swiper = new Swiper('.swiper-container', {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
            }
        });
    </script> -->

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>



    <script src="jquery.min.js"></script>
    <script src="owlcarousel/owl.carousel.min.js"></script>

@endsection
