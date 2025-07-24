<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalStaff;
use App\Models\Event;
use App\Models\StaffJadwalRegistrasi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalStaffController extends Controller
{
    // Menampilkan daftar jadwal staff dengan status registrasi
    public function index()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Ambil jadwal staff berdasarkan event yang masih berlangsung (start_date <= today <= finish_date)
        $regist = StaffJadwalRegistrasi::with(['staff', 'jadwalStaff.event'])
            ->where('status', 'Pending')
            ->get();

        return view('admin.schedule', compact('regist'));
    }

    public function create()
    {
        $events = Event::whereDoesntHave('jadwalStaff')->get();
        return view('admin.addSchedule', compact('events'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'event_id' => 'required|exists:event,id',
            'maks_staff' => 'required|array',
            'maks_staff.*' => 'required|numeric|min:1',
        ]);

        foreach ($request->maks_staff as $date => $max) {
            JadwalStaff::create([
                'event_id' => $request->event_id,
                'tgl_event' => $date,
                'maks_staff' => $max,
            ]);
        }

        return redirect()->route('dashboard.admin.viewschedule')->with('success', 'Jadwal berhasil dibuat.');
    }

    public function view()
    {
        $events = Event::whereHas('jadwalStaff')->get();

        $jadwalStaff = JadwalStaff::with(['event'])
            ->withCount(['registrasi as accepted_count' => function ($q) {
                $q->where('status', 'Confirmed');
            }])->get();

        return view('admin.viewSchedule', compact('events', 'jadwalStaff'));
    }

    public function register(Request $request, $jadwal_id)
    {
        $user = Auth::user();

        $registrasi = StaffJadwalRegistrasi::updateOrCreate(
            [
                'staff_id' => $user->id,
                'jadwal_staff_id' => $jadwal_id
            ],
            [
                'status' => 'Pending',
            ]
        );

        return redirect()->back()->with('success', 'Registrasi berhasil diajukan.');
    }

    public function accept($id)
    {
        $jadwal = StaffJadwalRegistrasi::findOrFail($id);
        $jadwal->status = 'Confirmed';
        $jadwal->save();

        $registjadwal = StaffJadwalRegistrasi::with(['jadwalStaff.event','staff'])->get();
        $events = Event::whereHas('jadwalStaff')->get();
        $jadwalStaff = JadwalStaff::with(['event'])
            ->withCount(['registrasi as accepted_count' => function ($q) {
                $q->where('status', 'Accepted');
            }])->get();

        return redirect()->route('dashboard.admin.viewschedule')->with('success', 'Registrasi Jadwal berhasil dikonfirmasi.');
    }

    public function reject($id)
    {
        $jadwal = StaffJadwalRegistrasi::findOrFail($id);
        $jadwal->status = 'Rejected';
        $jadwal->save();

        $registjadwal = StaffJadwalRegistrasi::with(['jadwalStaff.event','staff'])->get();
        $events = Event::whereHas('jadwalStaff')->get();
        $jadwalStaff = JadwalStaff::with(['event'])
            ->withCount(['registrasi as accepted_count' => function ($q) {
                $q->where('status', 'Accepted');
            }])->get();

        return  redirect()->route('dashboard.admin.viewschedule')->with('error', 'Registrasi Jadwal berhasil ditolak.');
    }

    public function edit($id){
        $jadwalStaff = JadwalStaff::findOrFail($id);
        return view('admin.editSchedule', compact('jadwalStaff'));
    }

    public function update(Request $request){
        
        $request->validate([
            'maks_staff' => 'required|numeric|min:1',
            'id' => 'required|exists:jadwal_staff,id',
        ]);

        $jadwalStaff = JadwalStaff::findOrFail($request->id);

        $jadwalStaff->update([
            'maks_staff' => $request->maks_staff,
        ]);
        return redirect()->route('dashboard.admin.viewschedule')->with('success', 'Schedule berhasil diperbarui!');
    }

    public function showRegistrants($schedule_id)
    {
        $staffs = StaffJadwalRegistrasi::with('staff')
                ->where('jadwal_staff_id', $schedule_id)
                ->where('status', 'Confirmed')
                ->get();

        $jadwal = JadwalStaff::findOrFail($schedule_id);

        return view('admin.staffschedule', compact('staffs', 'jadwal'));
    }

}
