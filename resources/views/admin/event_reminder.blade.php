<h2>Reminder Event: {{ $event->nama_event }}</h2>
<p>Halo, jangan lupa ada event yang akan datang:</p>
<ul>
    <li>Tanggal: {{ $event->start_date }} - {{ $event->finish_date }}</li>
    <li>Lokasi: {{ $event->lokasi }}</li>
</ul>
