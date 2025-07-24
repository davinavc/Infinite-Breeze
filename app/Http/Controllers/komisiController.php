<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komisi;
use App\Models\DetailKomisi;
use App\Models\Transaksi;
use Carbon\Carbon;

class KomisiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));
        $allYear = $request->has('all_year');

        // Buat tanggal awal dan akhir dari bulan yang dipilih
        $startOfMonth = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endOfMonth = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        // Ambil data komisi + total dari detail_komisi
        if ($user->role == 'Admin') {
            $transaksis = Transaksi::where('status', 'Successful')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->get()
                ->groupBy('referral_staff_id');

            // Ambil semua komisi yang cocok di rentang waktu tersebut
            $komisi = Komisi::with('staff')
                ->whereBetween('bulan', [$startOfMonth, $endOfMonth])
                ->get()
                ->map(function ($k) use ($transaksis) {
                    $referralUsage = $transaksis->get($k->staff_id)?->count() ?? 0;

                    $k->referral_usage = $referralUsage;
                    $k->total_komisi = $referralUsage * 100000;

                    return $k;
                });

            if ($allYear) {
                $transaksis = Transaksi::where('status', 'Successful')->get()
                    ->groupBy('referral_staff_id');

                $komisi = Komisi::with('staff')
                    ->get()
                    ->groupBy('staff_id')
                    ->map(function ($grouped, $staffId) use ($transaksis) {
                        $staff = $grouped->first()->staff;
                        $referralUsage = $transaksis->get($staffId)?->count() ?? 0;
                        return (object)[
                            'staff' => $staff,
                            'referral_usage' => $referralUsage,
                            'total_komisi' => $referralUsage * 100000,
                            'id' => $grouped->first()->id, // untuk link ke detail
                        ];
                    })
                    ->values();
            }

            return view('admin.komisi', compact('komisi', 'bulan', 'tahun'));

        } elseif ($user->role == 'Staff') {
            $staffId = $user->staff->id;
            $komisi = Komisi::with('staff', 'detailKomisi')
                ->where('staff_id', $staffId)
                ->whereBetween('bulan', [$startOfMonth, $endOfMonth])
                ->get()
                ->map(function ($k) use ($startOfMonth, $endOfMonth) {
                    $k->referral_usage = Transaksi::where('referral_staff_id', $k->staff->id)
                        ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                        ->where('status', 'Successful')
                        ->count();

                    $k->total_komisi = $k->referral_usage * 100000;

                    return $k;
                });

            $totalSemuaKomisi = $komisi->sum('total_komisi');
            return view('staff.komisiStaff', compact('komisi', 'bulan', 'tahun', 'totalSemuaKomisi'));
        }
    }

    public function show($id, Request $request)
    {
        $komisi = Komisi::with(['detailKomisi' => function ($query) {
            $query->whereHas('transaksi', function ($q) {
                $q->where('status', 'Successful');
            });
        }, 'detailKomisi.tenant', 'detailKomisi.transaksi.event', 'staff.departemen', 'staff.user']
        )->findOrFail($id);
        
        $from = $request->query('from', 'active');
        return view('admin.detailKomisi', compact('komisi', 'from'));
    }


}
