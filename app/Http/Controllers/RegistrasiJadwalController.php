<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StaffJadwalRegistrasi;
use App\Models\JadwalStaff;
use App\Models\Staff;

class RegistrasiJadwalController extends Controller
{
    //
    public function index()
    {
        $staff_id = auth()->user()->staff->id;

        $pending = StaffJadwalRegistrasi::with(['jadwalStaff.event'])
            ->where('staff_id', $staff_id)
            ->where('status', 'Pending')
            ->get();

        $confirmedRaw = StaffJadwalRegistrasi::with(['jadwalStaff.event'])
            ->where('staff_id', $staff_id)
            ->where('status', 'Confirmed')
            ->get();

        // Group by event_id
        $confirmed = $confirmedRaw->groupBy(function ($item) {
            return $item->jadwalStaff->event_id;
        });

        $others = StaffJadwalRegistrasi::with(['jadwalStaff.event'])
            ->where('staff_id', $staff_id)
            ->whereIn('status', ['Rejected', 'Cancel'])
            ->get();
        
        return view('staff.schedule', compact('pending', 'confirmed', 'others'));
    }

    public function register($event_id)
    {
        $jadwalList = JadwalStaff::withCount(['registrasi as accepted_count' => function ($q) {
            $q->where('status', 'Confirmed');
        }])
        ->where('event_id', $event_id)
        ->with(['event', 'registrasi'])
        ->orderBy('tgl_event')
        ->get();

        return view('staff.registSched', compact('jadwalList'));
    }

    // Menampilkan detail pendaftar untuk jadwal tertentu
    public function show($id)
    {
        $jadwal = JadwalStaff::with(['event', 'pendaftar.staff'])->findOrFail($id);
        return view('admin.jadwal.show', compact('jadwal'));
    }

    // Batalkan pendaftaran
    public function cancel($registrasi_id)
    {
        $staff = auth()->user()->staff->id;

        $registrasi = StaffJadwalRegistrasi::findOrFail($registrasi_id);
        $registrasi->status = 'Cancel';
        $registrasi->save();

        return back()->with('error', 'Pendaftaran dibatalkan.');
    }

    public function daftar(Request $request, $jadwal_id)
    {
        $staff_id = auth()->user()->staff->id;

        $existing = StaffJadwalRegistrasi::where('staff_id', $staff_id)
            ->where('jadwal_staff_id', $jadwal_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah mendaftar di tanggal ini.');
        }

        StaffJadwalRegistrasi::create([
            'staff_id' => $staff_id,
            'jadwal_staff_id' => $jadwal_id,
            'status' => 'Pending',
        ]);

        return redirect()->route('dashboard.staff.schedule')->with('success', 'Berhasil mendaftar, menunggu konfirmasi admin.');
    }

}
