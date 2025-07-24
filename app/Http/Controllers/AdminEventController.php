<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Komisi;
use App\Models\DetailKomisi;
use App\Models\Transaksi;
use App\Models\JadwalStaff;
use App\Models\Staff;
use App\Models\StaffJadwalRegistrasi;
use App\Models\RegistrasiTenant;
use Carbon\Carbon;
use App\Mail\EventReminderMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class AdminEventController extends Controller
{
    public function dashboard(Request $request)
    {
        $today = Carbon::today();

        // Event Ongoing: Yang status ongoing dan tanggal start paling awal
        $ongoingEvent = Event::whereDate('start_date', '<=', $today)
            ->whereDate('finish_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->first();

        // Event Upcoming: Yang start_date > hari ini dan terdekat
        $upcomingEvent = Event::whereDate('start_date', '>', $today)
            ->orderBy('start_date', 'asc')
            ->first();

        $latestEvents = Event::whereDate('finish_date', '<', $today)
            ->orderBy('finish_date', 'desc')
            ->take(3)
            ->get();

        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $startOfMonth = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endOfMonth = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $komisi = Komisi::with('staff')
                ->whereBetween('bulan', [$startOfMonth, $endOfMonth])
                ->limit(3) 
                ->get()
                ->map(function ($k) use ($startOfMonth, $endOfMonth) {
                        $k->referral_usage = Transaksi::where('referral_staff_id', $k->staff->id)
                            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                            ->where('status', 'Successful')
                            ->count();

                        $k->total_komisi = $k->referral_usage * 100000;

                        return $k;
                })
                ->sortByDesc('referral_usage')
                ->values();
            ;
        
        return view('dashboardAdmin', compact('ongoingEvent', 'upcomingEvent', 'komisi', 'latestEvents'));
    }

    // Menampilkan daftar event
    public function index(){
        $today = Carbon::today();
 
        $events = Event::where('finish_date', '>=', $today)->get();
        foreach ($events as $event) {
            if ($today->between(Carbon::parse($event->start_date), Carbon::parse($event->finish_date))) {
                $event->status = 'On Going';
            } elseif ($today->lt(Carbon::parse($event->start_date))) {
                $event->status = 'Upcoming';
            } else {
                $event->status = '-';
            }
        }
        return view('admin.event', compact('events'));
    }

    // Form untuk menambahkan event
    public function create(){
        return view('admin.addEvent');
    }

    // Menyimpan event baru
    public function store(Request $request){
        
        
        $request->validate([
            'event_name' => 'required|string|max:100',
            'place' => 'required|string|max:100',
            'theme' => 'required|string|max:100',
            'start_date' => 'required|date',
            'finish_date' => 'required|date|after_or_equal:start_date',
            'tenant_quota' => 'required|integer|min:0',
            'supported_electricity' => 'required|integer|min:0',
            'price_per_watt' => 'nullable|numeric|min:0',
            'tm' => 'nullable|date',
            'tm_link' => 'nullable|string',
            'harga' => 'nullable|numeric|min:0',
            'capital' => 'required|numeric|min:0',
            'revenue' => 'nullable|numeric|min:0',
            'poster' => 'nullable|image|max:2048',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        $event = Event::create([
            'event_name' => $request->event_name,
            'place' => $request->place,
            'theme' => $request->theme,
            'start_date' => $request->start_date,
            'finish_date' => $request->finish_date,
            'poster' => $posterPath,
            'tenant_quota' => $request->tenant_quota,
            'supported_electricity' => $request->supported_electricity,
            'price_per_watt' => $request->price_per_watt,
            'tm' => $request->tm,
            'tm_link' => $request->tm_link,
            'harga' => $request->harga,
            'capital' => $request->capital,
            'revenue' => $request->revenue,
        ]);

        return redirect()->route('dashboard.admin.event')->with('success', 'Event berhasil ditambahkan!');
    }
    
    // Menampilkan form edit event
    public function edit($id){
        $event = Event::findOrFail($id);
        return view('admin.editEvent', compact('event'));
    }
    
    public function edithist($id){
        $event = Event::findOrFail($id);
        $isFinished = Carbon::parse($event->finish_date)->lt(now());

        $editableFields = collect([
            'event_name' => $event->event_name,
            'theme' => $event->theme,
            'place' => $event->place,
            'tenant_quota' => $event->tenant_quota,
            'supported_electricity' => $event->supported_electricity,
            'price_per_watt' => $event->price_per_watt,
            'capital' => $event->capital,
            'revenue' => $event->revenue,
            'tm' => $event->tm,
            'tm_link' => $event->tm_link,
            'harga' => $event->harga,
            'poster' => $event->poster,
        ]);

        $hasEmptyField = $editableFields->contains(function ($val) {
            return is_null($val) || $val === '';
        });

        return view('admin.editEventhist', compact('event'));
    }

    // Memperbarui data event
    public function update(Request $request){
        
        $request->validate([
            'event_name' => 'required|string|max:255',
            'theme' => 'required|string|max:255',
            'capital' => 'required|numeric|min:0',
            'revenue' => 'nullable|numeric|min:0',
            'tenant_quota' => 'required|integer|min:0',
            'supported_electricity' => 'required|integer|min:0',
            'price_per_watt' => 'nullable|numeric|min:0',
            'tm' => 'nullable|date',
            'tm_link' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'place' => 'required|string|max:255',
            'start_date_edit' => 'required|date',
            'finish_date' => 'required|date|after_or_equal:start_date',
            'poster' => 'nullable|image|max:2048',
        ]);

        $event = Event::findOrFail($request->id);

        $posterPath = $event->poster;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
        }

        $event->update([
            'event_name' => $request->event_name,
            'place' => $request->place,
            'theme' => $request->theme,
            'start_date' => $request->start_date_edit,
            'finish_date' => $request->finish_date,
            'poster' => $posterPath,
            'tenant_quota' => $request->tenant_quota,
            'supported_electricity' => $request->supported_electricity,
            'price_per_watt' => $request->price_per_watt,
            'tm' => $request->tm,
            'tm_link' => $request->tm_link,
            'harga' => $request->harga,
            'capital' => $request->capital,
            'revenue' => $request->revenue,
        ]);

        $from = $request->input('from');
            if ($from === 'history') {
                return redirect()->route('dashboard.admin.eventhist')->with('success', 'Event berhasil diperbarui dari history!');
            } else {
                return redirect()->route('dashboard.admin.event')->with('success', 'Event berhasil diperbarui!');
            }    
    }

    public function sendReminderToStaff($eventId)
    {
        $event = Event::findOrFail($eventId);
        $staffs = Staff::where('status', '!=', 'Resign')->get();

        foreach ($staffs as $staff) {
            Mail::to($staff->user->email)->send(new EventReminderMail($event));
        }

        return back()->with('success', 'Reminder berhasil dikirim ke semua staff.');
    }

    public function history()
    {
        $today = Carbon::today();
        $historyEvents = Event::where('finish_date', '<', $today)
                        ->orderBy('start_date', 'desc')
                        ->get();

        foreach ($historyEvents as $event) {
            $event->status = 'Done';
        }
        return view('admin.eventHist', compact('historyEvents'));
    }

    public function show($id, Request $request)
    {
        $event = Event::findOrFail($id);
        $from = $request->query('from', 'active');
        return view('admin.detailEvent', compact('event', 'from'));
    }

    // Menyimpan batasan jumlah staff per hari untuk event tertentu
    public function saveDayLimits(Request $request, $event_id)
    {
        foreach ($request->maks_staff_per_hari as $tgl_event => $maks_staff) {
            EventDayLimit::updateOrCreate(
                ['event_id' => $event_id, 'tgl_event' => $tgl_event],
                ['maks_staff_per_hari' => $maks_staff]
            );
        }

        return redirect()->route('event.index')->with('success', 'Batasan jumlah staff per hari berhasil disimpan.');
    }
    
    public function generateJadwal(Request $request, $event_id)
    {
        $event = Event::findOrFail($event_id);

        $request->validate([
            'maks_staff' => 'required|integer|min:1',
        ]);

        $start = Carbon::parse($event->start_date);
        $end = Carbon::parse($event->finish_date);

        for ($date = $start; $date->lte($end); $date->addDay()) {
            JadwalStaff::updateOrCreate(
                ['event_id' => $event->id, 'tgl_event' => $date->toDateString()],
                ['maks_staff' => $request->maks_staff]
            );
        }

        return back()->with('success', 'Jadwal berhasil dibuat dari ' . $start->format('d M') . ' sampai ' . $end->format('d M Y'));
    }

}


