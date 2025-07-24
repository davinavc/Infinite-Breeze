@extends('layouts.app-blog')

@section('content')
<main>
    <div class="dashboard-content">
        <div class="staff-list">
            
            <a href="{{ route('blog.ongoing') }}" class="btn-back add-staff">
                <span class="material-symbols-outlined">chevron_left</span>          
                <span class="nav-label">Back</span>
            </a>
                <div class="d-flex justify-content-center">
                            <img src="{{ asset('storage/' . $event->poster) }}" class="detail-img" alt="Header Image">
                        </div>
            <div class="details-data">
                
                <p><strong>Event Name:</strong> {{ $event->event_name }}</p>
                <p><strong>Event Theme :</strong> {{ $event->theme }}</p>
                <p><strong>Place :</strong> {{ $event->place }}</p>
                <p><strong>Start Date:</strong> {{ $event->start_date ? \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') : ' - ' }}</p>
                <p><strong>Finish Date:</strong> {{ $event->finish_date ? \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') : ' - ' }}</p>
                <p><strong>Joined Tenants:</strong> {{ $tenants->count() }}</p>
            </div>
            <div class="tenants-logo">
                @if($tenants->count() > 0)
                    <div class="mt-4">
                        <h4 class="font-semibold">Tenants Joined This Event</h4>
                        <div style="display: flex; flex-wrap: wrap; gap: 16px; margin-top: 12px;">
                            @foreach($tenants as $tenant)
                                <div style="width: 150px; text-align: center;">
                                    @if($tenant->logo)
                                        <img src="{{ asset('storage/' . $tenant->logo) }}" 
                                            alt="{{ $tenant->name }}" 
                                            style="width: 250px; height: 210px; object-fit: contain; border: 1px solid #ccc; border-radius: 8px;">
                                    @else
                                        <div style="width: 150px; height: 150px; background: #ededed; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
                                            {{ $tenant->name }}
                                        </div>
                                    @endif
                                    <p style="font-size: 12px; margin-top: 4px;">{{ $tenant->name }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p class="mt-4"><em></em></p>
                @endif
            </div>
        </div> 
    </div>
</main>
@endsection
