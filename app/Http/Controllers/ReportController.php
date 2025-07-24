<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Event;
use App\Models\Staff;
use App\Models\Tenant;
use App\Models\Komisi;
use App\Models\DetailKomisi;
use Carbon\Carbon;


class ReportController extends Controller
{
    public function repevent(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $allYear = $request->input('all_year');

        $query = Event::query();

        if (!$allYear) {
            if ($bulan) {
                $query->whereMonth('start_date', $bulan);
            }
            if ($tahun) {
                $query->whereYear('start_date', $tahun);
            }
        }

        $events = $query->orderBy('start_date', 'desc')->get();

        $today = Carbon::today();
        foreach ($events as $event) {
            if ($event->start_date && $event->finish_date) {
                if ($today->between(Carbon::parse($event->start_date), Carbon::parse($event->finish_date))) {
                    $event->status = 'On Going';
                } elseif ($today->lt(Carbon::parse($event->start_date))) {
                    $event->status = 'Upcoming';
                } else {
                    $event->status = 'Done';
                }
            } else {
                $event->status = '-';
            }
        }

        return view('admin.repEvent', compact('events'));
    }

    public function reptransaksi(Request $request)
    {
       $query = Event::with(['transactions' => function ($q) {
            $q->where('status', 'Successful');
        }, 'transactions.tenant']);

        // Filter bulan & tahun jika tidak pilih "all year"
        if (!$request->has('all_year')) {
            if ($request->filled('bulan')) {
                $query->whereMonth('start_date', $request->bulan);
            }
            if ($request->filled('tahun')) {
                $query->whereYear('start_date', $request->tahun);
            }
        }

        $events = $query->orderBy('start_date', 'desc')->get();

        $transaksiList = $events->map(function ($event) {
            $totalTenant = $event->transactions->count();
            $totalNominal = $event->transactions->sum('total_price');

            return [
                'event' => $event,
                'total_tenant' => $totalTenant > 0 ? $totalTenant : '-',
                'total_nominal' => $totalNominal > 0 ? 'Rp ' . number_format($totalNominal, 0, ',', '.') : '-',
                'transaksi' => $event->transactions,
            ];
        });

        return view('admin.reptransaction', compact('transaksiList'));
    }

    public function repkomisi(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $allYear = $request->input('all_year');

        // Ambil semua staff
        $staffs = Staff::with('departemen')->get();

        // Ambil semua detail komisi dengan status transaksi 'Successful'
        $query = DetailKomisi::with(['komisi', 'transaksi'])
            ->whereHas('transaksi', function ($q) {
                $q->where('status', 'Successful');
            });

        // Jika filter bulan dan tahun dipilih
        if (!$allYear) {
            if ($bulan) {
                $query->whereMonth('created_at', $bulan);
            } elseif ($tahun) {
                $query->whereYear('created_at', $tahun);
            }
        }

        $refUsages = $query->get()->groupBy('komisi.staff_id')->map->count();

        // Siapkan data untuk ditampilkan di blade
        $data = $staffs->map(function ($staff) use ($refUsages) {
            return [
                'staff_id' => $staff->id,
                'name' => $staff->nm_depan . ' ' . $staff->nm_belakang,
                'department' => $staff->departemen->department ?? '-',
                'status' => $staff->status,
                'referral_usage' => $refUsages[$staff->id] ?? 0,
            ];
        });

        return view('admin.repkomisi', [
            'data' => $data,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'referralUsages' => $refUsages,
        ]);
    }

    public function reptenant(Request $request)
    {
        $search = $request->input('search');

        $tenantsQuery = Tenant::whereHas('transaksi', function ($q) {
            $q->where('status', 'Successful');
        })
        ->withCount([
            'transaksi as events_count' => function ($q) {
                $q->where('status', 'Successful');
            }
        ])
        ->with(['transaksi' => function ($q) {
            $q->where('status', 'Successful')->with('event');
        }]);

        if ($search) {
            $tenantsQuery->where('tenant_name', 'like', '%' . $search . '%');
        }

        $tenants = $tenantsQuery->get();

        return view('admin.repTenant', compact('tenants', 'search'));
        
    }

    public function reportevent($id)
    {
        $event = Event::with(['transactions.tenant', 'jadwalStaff.registrasi.staff'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.report.event', compact('event'));

        // return view('admin.report.event', compact('event'));
        return $pdf->stream('laporan-event-' . $event->event_name . '.pdf');
    }

    public function allevent(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $query = Event::with(['transactions.tenant', 'jadwalStaff.registrasi.staff']);

        if ($bulan) {
            $query->whereMonth('start_date', $bulan);
        }

        if ($tahun) {
            $query->whereYear('start_date', $tahun);
        }

        $allYear = $request->input('all_year');

        if (!$allYear) {
            if ($bulan) {
                $query->whereMonth('start_date', $bulan);
            }
            if ($tahun) {
                $query->whereYear('start_date', $tahun);
            }
        }

        $event = $query->orderBy('start_date', 'desc')->get();

        $pdf = Pdf::loadView('admin.report.allEvent', compact('event', 'bulan', 'tahun'));

        return $pdf->stream("laporan-semua-event-{$bulan}-{$tahun}.pdf");
    }

    public function reportkomisi(Request $request, $id)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $allYear = $request->input('all_year');

        $staff = Staff::with('departemen')->findOrFail($id);

        // Ambil semua komisi dari staff ini
        $komisiQuery = Komisi::with(['transaksi.tenant', 'transaksi.event'])
            ->where('staff_id', $id)
            ->whereHas('transaksi', function ($q) {
                $q->where('status', 'Successful');
            });

        if ($bulan) {
            $komisiQuery->whereMonth('created_at', $bulan);
        }

        if ($tahun) {
            $komisiQuery->whereYear('created_at', $tahun);
        }

        $komisiList = $komisiQuery->get();

        $pdf = Pdf::loadView('admin.report.komisi', [
            'staff' => $staff,
            'komisiList' => $komisiList,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        return $pdf->stream('laporan-komisi-' . $staff->nm_depan . '.pdf');
    }

    public function allkomisi(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $allYear = $request->input('all_year');

        // Ambil semua staff
        $staffs = Staff::with('user', 'departemen')->get();

        // Ambil semua komisi yang berhasil, dikelompokkan berdasarkan staff_id
        $query = Komisi::with(['transaksi.tenant', 'transaksi.event', 'staff'])
            ->whereHas('transaksi', function ($q) {
                $q->where('status', 'Successful');
            });
            
        $referralQuery = DetailKomisi::with('komisi', 'transaksi')
            ->whereHas('transaksi', function ($q) use ($bulan, $tahun, $allYear) {
                $q->where('status', 'Successful');

                if (!$allYear) {
                    if ($bulan) {
                        $q->whereMonth('created_at', $bulan);
                    }
                    if ($tahun) {
                        $q->whereYear('created_at', $tahun);
                    }
                }
            });


        if (!$allYear) {
            if ($bulan) {
                $query->whereMonth('created_at', $bulan);
            }
            if ($tahun) {
                $query->whereYear('created_at', $tahun);
            }
        }

        $komisiList = $query->get()->groupBy('staff_id');

        

        $referralUsages = $referralQuery->get()
            ->groupBy(fn($item) => $item->komisi->staff_id)
            ->map(fn($items) => $items->count());

        $pdf = Pdf::loadView('admin.report.allkomisi', [
            'staffs' => $staffs,
            'komisiList' => $komisiList,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'referral_usage' => $referralUsages
        ]);

        return $pdf->stream('laporan-komisi-semua-staff.pdf');
        
    }
    
    public function reporttransaksi($id)
    {
        $event = Event::findOrFail($id);

        $transaksiList = Transaksi::with('tenant')
            ->where('event_id', $id)
            ->where('status', 'Successful') // misalnya hanya yang sukses
            ->get();

        $pdf = Pdf::loadView('admin.report.transaksi', [
            'event' => $event,
            'transaksiList' => $transaksiList
        ]);

        return $pdf->stream('laporan-transaksi-' . $event->event_name . '.pdf');
    }

    public function alltransaksi(Request $request)
    {
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $allYear = $request->input('all_year');

        $query = Event::with(['transactions' => function ($q) {
            $q->where('status', 'Successful');
        }]);

        if (!$allYear) {
            if ($bulan) {
                $query->whereMonth('start_date', $bulan);
            }
            if ($tahun) {
                $query->whereYear('start_date', $tahun);
            }
        }

        $events = $query->orderBy('start_date', 'desc')->get();

        $pdf = Pdf::loadView('admin.report.allTransaksi', [
            'events' => $events,
            'bulan' => $bulan,
            'tahun' => $tahun
        ]);

        return $pdf->stream("Report-All-Transaction-{$bulan}-{$tahun}.pdf");
    }

    public function detailtransaksi($id)
    {
        $event = Event::findOrFail($id);

        $transactions = Transaksi::with('tenant')
            ->where('event_id', $id)
            ->where('status', 'Successful')
            ->get();
            
        return view('admin.report.detailtransaksi', compact('event', 'transactions'));
    }

    public function reporttenant($id)
    {
        $tenant = Tenant::with('user')->findOrFail($id);

        $registrations = $tenant->registrations()
            ->with(['event'])
            ->get();

        $transaksis = Transaksi::where('tenant_id', $tenant->id)
            ->where('status', 'Successful')
            ->get()
            ->keyBy(function ($item) {
                return $item->event_id; // Bisa ditambah tenant_id jika perlu
            });

        // Tambahkan count event successful
        $tenant->events_count = $transaksis->count();

        $pdf = Pdf::loadView('admin.report.tenant', [
            'tenants' => $tenant,
            'registrations' => $registrations,
            'transaksis' => $transaksis,
        ]);

        return $pdf->stream('report-tenant-' . $tenant->tenant_name . '.pdf');
    }

    public function alltenant(Request $request)
    {
        $search = $request->input('search');

        $tenants = Tenant::with(['user', 'registrations.event', 'transaksi'])
            ->withCount([
                'transaksi as joined_event' => function ($query) {
                    $query->where('status', 'Successful');
                }
            ])
            ->when($search, function ($query, $search) {
                $query->where('tenant_name', 'like', '%' . $search . '%');
            })
            ->get();

        $pdf = Pdf::loadView('admin.report.alltenant', compact('tenants'));

        return $pdf->stream('report-all-tenant.pdf');
    }

    public function invoice($tenantId, $eventId)
    {
        // Ambil tenant
        $tenant = Tenant::findOrFail($tenantId);
        
        // Ambil event
        $event = Event::findOrFail($eventId);

        $transaksi = Transaksi::with(['event', 'tenant.user'])
            ->where('tenant_id', $tenantId)
            ->where('event_id', $eventId)
            ->where('status', 'Successful')
            ->firstOrFail();


        $pdf = Pdf::loadView('admin.report.invoice', compact('tenant', 'event', 'transaksi'));

        return $pdf->stream('invoice-' . $tenant->tenant_name . '-' . $event->event_name . '.pdf');
    }

    public function invoicetenant($tenantId, $eventId)
    {
        // Ambil tenant
        $tenant = Tenant::findOrFail($tenantId);
        
        // Ambil event
        $event = Event::findOrFail($eventId);

        $transaksi = Transaksi::with(['event', 'tenant.user'])
            ->where('tenant_id', $tenantId)
            ->where('event_id', $eventId)
            ->where('status', 'Successful')
            ->firstOrFail();


        $pdf = Pdf::loadView('admin.report.invoice', compact('tenant', 'event', 'transaksi'));

        return $pdf->stream('invoice-' . $tenant->tenant_name . '-' . $event->event_name . '.pdf');
    }


}
