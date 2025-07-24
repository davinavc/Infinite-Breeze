<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Event;
use App\Models\Staff;
use App\Models\Komisi;
use App\Models\DetailKomisi;
use App\Models\RegistrasiTenant;

class TransaksiTenantController extends Controller
{
    public function index()
    {
       $tenantId = auth()->user()->tenant->id;
       $today = Carbon::today();

        $registrasiList = RegistrasiTenant::with(['event'])
            ->where('tenant_id', $tenantId)
            ->where('status', 'Confirmed')
            ->get();

        // buat ambil semua transaksi tenant
        $transaksiList = Transaksi::where('tenant_id', $tenantId)->get();

        // Pasangkan transaksi ke registrasi secara manual berdasarkan tenant_id & event_id
        $activeTransactions = [];
        foreach ($registrasiList as $reg) {
            $trx = $transaksiList->first(function ($trx) use ($reg) {
                return $trx->event_id == $reg->event_id;
            });

            $reg->transaksi = $trx;
            $event = $reg->event;
            $eventDone = Carbon::parse($event->finish_date)->lt($today);
            $statusTransaksi = $trx ? $trx->status : 'Not Paid';

            if (
                (!$trx && !$eventDone) || // Belum ada transaksi dan event belum selesai (Not Paid)
                ($trx && in_array($statusTransaksi, ['Not Paid', 'Pending']) && !$eventDone) || // Transaksi belum selesai dan event belum selesai
                ($trx && $statusTransaksi === 'Successful' && !$eventDone) // Transaksi sukses tapi event masih berlangsung
            ) {
                $activeTransactions[] = $reg;
            }
        }

        return view('tenant.transaction', ['transactions' => $activeTransactions]);
    }

    public function adminIndex()
    {
        $transactions = Transaksi::with(['event', 'tenant'])
            ->whereIn('status', ['Pending'])
            ->get();

        return view('admin.transaction', compact('transactions'));
    }

    public function viewadmin()
    {
        $today = Carbon::today();

        $transactions = Transaksi::with(['event', 'tenant'])
        ->where('status', 'Successful')
        ->whereHas('event', function ($query) use ($today) {
            $query->whereDate('finish_date', '>=', $today);
        })
        ->get();

        return view('admin.viewTransaction', compact('transactions'));
    }

    public function startFromRegistrasi($registrasiId)
    {
        $registrasi = RegistrasiTenant::findOrFail($registrasiId);

        if ($registrasi->status !== 'Confirmed') {
            return back()->with('error', 'Registrasi belum dikonfirmasi.');
        }

        // Optional: set status registrasi jadi Cancelled agar tidak muncul lagi
        $registrasi->status = 'Cancelled';
        $registrasi->save();

        return redirect()->route('tenant.transaksi.create', [
            'tenant_id' => $registrasi->tenant_id,
            'event_id' => $registrasi->event_id
        ]);
    }

    public function create(Request $request)
    {
        // Ambil data tenant_id dan event_id dari route query
        $tenant_id = $request->tenant_id;
        $event_id = $request->event_id;
        $event = Event::findOrFail($event_id);

        return view('tenant.formTransaksi', compact('tenant_id', 'event_id', 'event'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tenant_id' => 'required',
            'event_id' => 'required',
            'papan_nama' => 'required',
            'referral_code' => 'nullable|string',
            'nama_pemesan' => 'required',
            'watt_listrik' => 'required|numeric',
            'listrik_24_jam' => 'required',
            'bukti_transaksi' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'total_price' => 'required|numeric',
        ]);

        $referralStaffId = null;

        if ($request->filled('referral_code')) {
            $referralCode = strtoupper($request->referral_code);
            $staff = Staff::where('referral_code', $request->referral_code)->first();

            if ($staff) {
                $referralStaffId = $staff->id;
            }
            else {
                return back()->with('error', 'Kode referral tidak ditemukan');
            }
        }

        $path = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');

        Transaksi::create([
            'tenant_id' => $request->tenant_id,
            'event_id' => $request->event_id,
            'referral_staff_id' => $referralStaffId,
            'papan_nama' => $request->papan_nama,
            'nama_pemesan' => $request->nama_pemesan,
            'watt_listrik' => $request->watt_listrik,
            'listrik_24_jam' => $request->listrik_24_jam,
            'bukti_transaksi' => $path,
            'total_price' => $request->total_price,
            'status' => 'Pending',
        ]);

        return redirect()->route('dashboard.tenant.transaction')->with('success', 'Transaksi berhasil dikirim dan menunggu verifikasi.');
    }

    public function markAsPaid($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = 'Paid';
        $transaksi->save();

        return redirect()->route('dashboard.tenant.transaction')->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function cancel($id)
    {
        $tenantId = auth()->user()->tenant->id;

        // Cari berdasarkan ID dari transaksi, bukan event
        $transaksi = Transaksi::where('id', $id)
            ->where('tenant_id', $tenantId)
            ->first();

        if ($transaksi) {
            $transaksi->status = 'Cancel'; // Pastikan enum-nya sesuai dengan yang di DB
            $transaksi->save();
            return back()->with('error', 'Transaksi berhasil dibatalkan.');
        }

        return back()->with('error', 'Transaksi tidak ditemukan.');
    }

    public function history()
    {
        $user = Auth::user();
        $role = strtolower($user->role);

        $today = Carbon::today();

        if ($role === 'admin') {
            $historyTransactions = Transaksi::with(['event', 'tenant'])
                ->whereIn('status', ['Cancel', 'Rejected', 'Refund', 'Successful'])
                ->whereHas('event', function ($query) use ($today) {
                    $query->whereIn('status', ['Cancelled', 'Rejected', 'Refunded'])
                        ->orWhere(function ($q) use ($today) {
                            $q->where('status', 'Successful')
                                ->where('finish_date', '<', $today); // ini fixnya
                        });
                })
                ->get();

            return view('admin.transactionhist', compact('historyTransactions'));
        
        } elseif ($role === 'tenant') {
            $tenantId = auth()->user()->tenant->id;

            $allowedStatuses = ['Cancel', 'Successful', 'Rejected', 'Refund'];

            $registrasiList = RegistrasiTenant::with(['event', 'tenant'])
                ->where('tenant_id', $tenantId)
                ->where('status', 'Confirmed')
                ->get();

            $transaksiList = Transaksi::where('tenant_id', $tenantId)
                ->whereIn('status', $allowedStatuses)
                ->get();

            $finalRegistrasiList = [];

            foreach ($registrasiList as $reg) {
                $trx = $transaksiList->first(function ($trx) use ($reg) {
                    return $trx->event_id == $reg->event_id;
                });

                if ($trx) {
                    $reg->transaksi = $trx;
                    $finalRegistrasiList[] = $reg; // hanya tambahkan yang punya transaksi valid
                }
            }


            return view('tenant.histTransaksi', ['transactions' => $finalRegistrasiList]);
                }

    }

    public function accept($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = 'Successful';
        $transaksi->save();

        if ($transaksi->referral_staff_id) {
            $staffId = $transaksi->referral_staff_id;
            $totalKomisi = Transaksi::where('referral_staff_id', $staffId)
                        ->where('status', 'Successful')
                        ->count() * 100000;

            // Cek apakah sudah ada entri di tabel komisi
            $bulanIni = Carbon::now()->startOfMonth()->toDateString();
            $komisi = Komisi::where('staff_id', $staffId)
                        ->where('bulan', $bulanIni)
                        ->first();

            if (!$komisi) {
            // Buat baru jika belum ada
                $komisi = Komisi::create([
                    'staff_id' => $staffId,
                    'bulan' => $bulanIni,
                ]);
            }

            // Tambahkan total komisi di parent
            $komisiTotal = $komisi->detailKomisi->sum('total_komisi');

            // Simpan detail komisi
             DetailKomisi::create([
                'komisi_id' => $komisi->id,
                'tenant_id' => $transaksi->tenant_id,
                'transaksi_id' => $transaksi->id,
                'total_komisi' => $totalKomisi,
                'created_at' => Carbon::now(),
            ]);
        }
        return back()->with('success', 'Transaksi berhasil diterima.');
    }

    public function reject($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status = 'Rejected';
        $transaksi->save();

        return back()->with('success', 'Transaksi berhasil ditolak.');
    }

    public function show ($id, Request $request)
    {
        $registrasi = RegistrasiTenant::findOrFail($id);
        $from = $request->query('from', 'active');

        $tenant = $registrasi->tenant;
        $event = $registrasi->event;
        $transaksi = Transaksi::with(['tenant', 'event'])->findOrFail($id);

        return view('admin.detailTransaksi', compact('transaksi', 'tenant', 'event', 'from'));
    }

}
