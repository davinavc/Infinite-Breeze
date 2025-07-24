<h2>New Event: {{ $event->event_name }}</h2>
<p>Halo, jangan lupa untuk registrasi jadwal kerja event yang akan datang:</p>
<ul>
    <li>Tanggal: {{ \Carbon\Carbon::parse($event->start_date)->format('d-m-Y') }} - 
           {{ \Carbon\Carbon::parse($event->finish_date)->format('d-m-Y') }}</li>
    <li>Lokasi: {{ $event->place }}</li>
</ul>
