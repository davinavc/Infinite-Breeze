@extends('layouts.app-blog')

@section('content')
    <main>
        <center><h2 class="upcoming-h2" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="100">UP COMING EVENT</h2></center>

        <div class="container my-5 space-event" >
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @forelse ($events as $event)
                <div class="col" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="200">
                    <div class="card shadow">
                        <img src="{{ asset('storage/' . $event->poster) }}" class="card-img-top" alt="{{ $event->nama_event }}">
                        <div class="card-body general">
                            <h5 class="card-title">{{ $event->event_name }}</h5>
                            <p class="card-text d-flex align-items-center mb-1" ><span class="material-symbols-outlined me-2">calendar_month</span>
                                {{ \Illuminate\Support\Str::limit($event->start_date, 100) }}</p>
                            <p class="card-text card-text d-flex align-items-center mb-2"><span class="material-symbols-outlined me-2">distance</span>
                                {{ \Illuminate\Support\Str::limit($event->place, 30) }}</p>
                            <a class="card-text d-flex justify-content-end read-more" href="{{ route('blog.detailupcoming', $event->id ) }}">Read More <span class="material-symbols-outlined">arrow_forward</span></a>
                        </div>
                        <div class="card-footer">
                            <small class="text-muted">Tanggal: {{ \Carbon\Carbon::parse($event->created_at)->translatedFormat('d F Y') }}</small>
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
    </main>

@endsection
