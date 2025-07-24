<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\JadwalStaff;
use App\Models\Staff;
use App\Models\StaffJadwalRegistrasi;
use App\Models\RegistrasiTenant;
use App\Models\Transaksi;
use App\Models\Komisi;
use App\Models\DetailKomisi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function dashboardStaff()
    {
        $today = Carbon::today();
        $user = Auth::user();
        $staffId = Auth::user()->staff->id;

        // Ambil event yang masih aktif (upcoming & ongoing)
        $activeEvents = Event::where('finish_date', '>=', $today)->get();
        
        $upcoming = null;
        $ongoing = null;

        foreach ($activeEvents as $event) {
            if (Carbon::parse($event->start_date)->gt($today)) {
                if (!$upcoming || Carbon::parse($event->start_date)->lt($upcoming->start_date)) {
                    $upcoming = $event;
                }
            } elseif ($today->between(Carbon::parse($event->start_date), Carbon::parse($event->finish_date))) {
                if (!$ongoing || Carbon::parse($event->start_date)->lt($ongoing->start_date)) {
                    $ongoing = $event;
                }
            }
        }

        // Ambil event terakhir yang pernah diikuti oleh staff
                // Ambil 3 event terbaru yang sudah selesai dan pernah diikuti staff
        $latestEvents = Event::whereIn('id', function ($query) use ($staffId) {
                $query->select('jadwal_staff.event_id')
                    ->from('staff_jadwal_registrasi')
                    ->join('jadwal_staff', 'staff_jadwal_registrasi.jadwal_staff_id', '=', 'jadwal_staff.id')
                    ->where('staff_jadwal_registrasi.staff_id', $staffId)
                    ->where('staff_jadwal_registrasi.status', 'Confirmed');
            })
            ->where('finish_date', '<', $today)
            ->orderByDesc('finish_date')
            ->take(3)
            ->get();


        // Hitung jumlah hari kerja
        $workDaysPerEvent = [];

        foreach ($latestEvents as $event) {
            $jadwalIds = JadwalStaff::where('event_id', $event->id)
                ->pluck('id');

            $workDays = StaffJadwalRegistrasi::where('staff_id', $staffId)
                ->whereIn('jadwal_staff_id', $jadwalIds)
                ->where('status', 'Confirmed')
                ->count();

            $event->work_days = $workDays;
            $workDaysPerEvent[$event->id] = $workDays;
        }

        // Hitung total komisi untuk event terakhir
        $komisiPerEvent = [];

        if ($latestEvents->isNotEmpty()) {
            foreach ($latestEvents as $event) {
                $total = DetailKomisi::whereHas('komisi', function ($query) use ($staffId) {
                        $query->where('staff_id', $staffId);
                    })
                    ->whereHas('transaksi', function ($query) use ($event) {
                        $query->where('event_id', $event->id)
                            ->where('status', 'Successful');
                    })
                    ->sum('total_komisi');

                $komisiPerEvent[$event->id] = $total > 0 ? $total : '-';
            }
        }

        $totalSemuaEvent = collect($komisiPerEvent)->filter(fn($val) => is_numeric($val))->sum();

        return view('dashboardStaff', compact('upcoming', 'ongoing', 'komisiPerEvent', 'latestEvents', 'totalSemuaEvent'));
    }
    

    public function dashboardTenant()
    {
        $today = Carbon::today();
        $user = Auth::user();

        $tenantId = $user->tenant->id;

        // Bmbil semua transaksi Successfull milik tenant
        $successTrans = Transaksi::with('event')
            ->where('tenant_id', $tenantId)
            ->where('status', 'Successful')
            ->get();

        $upcoming = null;
        $ongoing = null;
        $latestEvents = [];

        foreach ($successTrans as $trx) {
            $event = $trx->event;
            if (!$event) continue;

            if (Carbon::parse($event->start_date)->gt($today)) {
                // Upcoming → ambil yang paling dekat
                if (!$upcoming || Carbon::parse($event->start_date)->lt($upcoming->start_date)) {
                    $upcoming = $event;
                }
            } elseif ($today->between(Carbon::parse($event->start_date), Carbon::parse($event->finish_date))) {
                // Ongoing → ambil yang paling awal mulai
                if (!$ongoing || Carbon::parse($event->start_date)->lt($ongoing->start_date)) {
                    $ongoing = $event;
                }
            } elseif (Carbon::parse($event->finish_date)->lt($today)) {
                // Selesai → tambahkan ke daftar latest
                $latestEvents[] = $event;
            }
        }

        // Sort dan ambil 3 event terakhir
        $latestEvents = collect($latestEvents)
            ->sortByDesc('finish_date')
            ->take(3);

        return view('dashboardTenant', compact('upcoming', 'ongoing', 'latestEvents'));
    }

    // Menampilkan daftar event
    public function index(){
        $today = Carbon::today();
        $user = Auth::user();

        // STAFF
        if (strtolower($user->role) === 'staff') {
            $staffId = Auth::user()->staff->id;
            // Ambil event yang masih aktif
            $events = Event::with('jadwalStaff')->where('finish_date', '>=', $today)->get();

            // Pisah upcoming dan ongoing
            $upcomingEvents = $events->filter(function ($event) use ($today) {
                return $today->lt(Carbon::parse($event->start_date));
            });

            $ongoingEvents = $events->filter(function ($event) use ($today) {
                return $today->between(Carbon::parse($event->start_date), Carbon::parse($event->finish_date));
            });

            // Tambah status pendaftaran dari registrasi jadwal_staff (jika ada)
            foreach ($upcomingEvents as $event) {
                // Ambil jadwal staff di event ini yang tgl_event >= sekarang (upcoming)
                $jadwalStaffs = JadwalStaff::where('event_id', $event->id)
                    ->where('tgl_event', '>=', $today)->get();

                $statusPendaftaran = 'Belum Mendaftar';

                foreach ($jadwalStaffs as $jadwal) {
                    $registrasi = StaffJadwalRegistrasi::where('staff_id', $user->id)
                        ->where('jadwal_staff_id', $jadwal->id)
                        ->first();

                    if ($registrasi) {
                        $statusPendaftaran = $registrasi->status;
                        break; // Ambil status pendaftaran pertama yang ditemukan
                    }
                }
                $event->status_pendaftaran = $statusPendaftaran;
            }

            foreach ($ongoingEvents as $event) {
                // Ambil jadwal staff di event ini yang tgl_event <= sekarang (ongoing)
                $jadwalStaffs = JadwalStaff::where('event_id', $event->id)
                    ->where('tgl_event', '<=', $today)->get();

                $statusPendaftaran = 'Tidak Mendaftar';
                $sudahDaftar = false;

                foreach ($jadwalStaffs as $jadwal) {
                     $registrasi = StaffJadwalRegistrasi::where('staff_id', $staffId)
                        ->where('jadwal_staff_id', $jadwal->id)
                        ->whereIn('status', ['Pending', 'Confirmed']) // atau status lain yang diinginkan
                        ->first();

                    if ($registrasi) {
                        $statusPendaftaran = $registrasi->status;
                        $sudahDaftar = true;
                        break;
                    }
                }

                $event->status_pendaftaran = $statusPendaftaran;
                $event->sudah_daftar = $sudahDaftar;
            }

            return view('staff.listEvent', compact('upcomingEvents', 'ongoingEvents'));
        }

        // TENANT
        if (strtolower($user->role) === 'tenant') {
            $events = Event::with(['registrations' => function($query) use ($user) {
                $query->where('tenant_id', $user->tenant->id);
            }])
            ->whereDate('start_date', '>', $today)
            ->get();

            foreach ($events as $event) {
                $event->status = 'Upcoming';

                // Cek status registrasi tenant ini untuk event ini
                $registration = $event->registrations->first(); // ambil registrasi tenant yg login
                if ($registration) {
                    $event->registration_status = $registration->status; // misal Pending/Confirmed/Cancelled
                } else {
                    $event->registration_status = null;
                }
            }

            return view('tenant.listEvent', compact('events'));
        }

        abort(403);
    }

    public function history()
    {
        $today = Carbon::today();
        $historyEvents = Event::where('finish_date', '<', $today)->get();
        $user = Auth::user();

        $role = strtolower($user->role);

        if ($role === 'staff') {
            $staffId = $user->staff->id;
            
            // Ambil semua jadwal yang didaftarkan oleh staff
            $jadwalIds = StaffJadwalRegistrasi::where('staff_id', $staffId)->pluck('jadwal_staff_id');

            // Ambil event_id dari jadwal yang selesai
            $eventIds = JadwalStaff::whereIn('id', $jadwalIds)
                ->where('tgl_event', '<', $today)
                ->pluck('event_id')
                ->unique();

            // Ambil event yang sudah selesai dan pernah diikuti oleh staff ini
            $historyEvents = Event::whereIn('id', $eventIds)
                ->where('finish_date', '<', $today)
                ->get();
            
            foreach ($historyEvents as $event) {
                $jadwalIdsEvent = JadwalStaff::where('event_id', $event->id)
                    ->pluck('id');

                $workDays = StaffJadwalRegistrasi::where('staff_id', $staffId)
                    ->whereIn('jadwal_staff_id', $jadwalIdsEvent)
                    ->where('status', 'Confirmed')
                    ->count();

                $event->work_days = $workDays;
            }

            return view('staff.histEvent', compact('historyEvents'));
        
        } elseif ($role === 'tenant') {
            $tenantId = $user->tenant->id;

            // Ambil transaksi sukses yang sudah selesai
            $eventIds = Transaksi::where('tenant_id', $tenantId)
                ->where('status', 'Successfull')
                ->pluck('event_id');

            $historyEvents = Event::whereIn('id', $eventIds)
                ->where('finish_date', '<', $today)
                ->get();

            return view('tenant.eventHist', compact('historyEvents'));
        }
        foreach ($historyEvents as $event) {
            $event->status = 'Done';
        }
    }

    public function show($id, Request $request)
    {
        $event = Event::findOrFail($id);
        $from = $request->query('from', 'active');
        $user = Auth::user();

        $role = strtolower($user->role);

        if ($role === 'staff') {
            return view('staff.detailEvent', compact('event', 'from'));
        } elseif ($role === 'tenant') {
            return view('tenant.detailEvent', compact('event', 'from'));
        }

        abort(403, 'Akses tidak diizinkan.');
    }

}


