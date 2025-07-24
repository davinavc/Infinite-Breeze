<!DOCTYPE html>
<html>
<head>
    <title>Jadwal Staff</title>
</head>
<body>
    <h1>Jadwal Staff</h1>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Event</th>
                <th>Staff</th>
                <th>Tanggal Dipilih</th>
            </tr>
        </thead>
        <tbody>
            @foreach($jadwal_staff as $jadwal)
            <tr>
                <td>{{ $jadwal->id_jadwal }}</td>
                <td>{{ $jadwal->event->nm_event }}</td>
                <td>{{ $jadwal->staff->nm_staff }}</td>
                <td>{{ $jadwal->tgl_dipilih }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <!-- form admin input batasan staff per hari -->
    <form action="{{ route('event.save_day_limits', $event->event_id) }}" method="POST">
    @csrf
    @foreach ($event->event_days as $day)
        <label>Tanggal: {{ $day->tgl_event }}</label>
        <input type="number" name="maks_staff_per_hari[{{ $day->tgl_event }}]" value="{{ $day->maks_staff_per_hari }}" required>
    @endforeach

    <button type="submit">Simpan Batasan</button>
    </form>

</body>
</html>
