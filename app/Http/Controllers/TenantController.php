<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Staff;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Transaksi;

class TenantController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        if (strtolower($user->role) === 'admin') {
            $today = now();

            $transaksiAktif = Transaksi::where('status', 'Successful')
                ->whereHas('event', function ($query) use ($today) {
                    $query->whereDate('start_date', '>=', $today) // upcoming
                        ->orWhere(function ($query) use ($today) {
                            $query->whereDate('start_date', '<=', $today)
                                    ->whereDate('finish_date', '>=', $today); // ongoing
                        });
                })
                ->with(['tenant.user', 'event'])
                ->get();

            return view('admin.tenant', compact('transaksiAktif'));
        }

        if (strtolower($user->role) === 'staff') {
            $staff = $user->staff;
            $today = now();

            $transaksiAktif = Transaksi::where('status', 'Successful')
                ->whereHas('event', function ($query) use ($today) {
                    $query->whereDate('start_date', '>=', $today) // upcoming
                        ->orWhere(function ($query) use ($today) {
                            $query->whereDate('start_date', '<=', $today)
                                    ->whereDate('finish_date', '>=', $today); // ongoing
                        });
                })
                ->with(['tenant.user', 'event', 'staffFollowUp'])
                ->get();

            return view('staff.tenant', compact('transaksiAktif'));
        }
        if (strtolower($user->role) === 'Tenant') {
            $staff = $user->staff;
            $tenants = Tenant::where('kode_referal', $staff->referral_code)->get();

            return view('dashboardTenant', compact('tenants'));
        }

        abort(403);
    }

    // Menampilkan form tambah staff
    public function create()
    {
        if (auth()->user()->tenant) {
            return redirect()->route('dashboard.tenant');
        }

        return view('tenant.formData');
    }

    public function store(Request $request)
    {
        $request->validate([
        'tenant_name' => 'required|string|max:100',
        'category_name' => 'required|string|max:100',
        'nama_bank' => 'required|string|max:100',
        'rekening' => 'required|string|max:20',
        'alamat' => 'required|string|max:100',
        'logo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload logo
        $logoPath = $request->file('logo')->store('logos', 'public');

        // Simpan data tenant dengan user_id yang sedang login
        Tenant::create([
            'user_id' => auth()->id(),
            'tenant_name' => $request->tenant_name,
            'category_name' => $request->category_name,
            'nama_bank' => $request->nama_bank,
            'rekening' => $request->rekening,
            'alamat' => $request->alamat,
            'logo' => $logoPath,
        ]);

        return redirect()->route('dashboard.tenant')->with('success', 'Tenant berhasil ditambahkan.');
    }

    public function followUp($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->follow_up_by = Auth::user()->staff->id; // pastikan user login adalah staff
        $transaksi->save();

        return redirect()->back()->with('success', 'Follow up berhasil dicatat.');
    }

    public function edit($id)
    {
        $tenant = Tenant::with('user')->findOrFail($id);
        return view('tenant.editTenant', compact('tenant'));
    }

    public function update(Request $request)
    {

        // dd($request->all());
        $tenant = Tenant::with('user')->find($request->id);

        if (!$tenant) {
            return redirect()->back()->with('error', 'Data tenant tidak ditemukan!');
        }

        // Validasi input
        $request->validate([
            'id' => 'required|exists:tenant,id',
            'email' => 'required|email|unique:users,email,' . $tenant->user->id,
            'no_telp' => ['required', 'regex:/^[0-9]+$/', 'digits_between:10,14'],
            'tenant_name' => 'required|string|max:100',
            'category_name' => 'required|string|max:100',
            'nama_bank' => 'required|string|max:100',
            'rekening' => 'required|string|max:20',
            'alamat' => 'required|string|max:100',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'no_telp.digits_between' => 'Nomor telepon harus terdiri dari minimal 10 dan maksimal 14 angka.',
            'no_telp.regex' => 'Nomor telepon hanya boleh berisi angka.',
        ]);

        // Update user terkait
        $user = $tenant->user;
        $user->email = $request->email;
        $user->no_telp = $request->no_telp;
        $user->save();

        // Cek apakah logo diupload
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            $tenant->logo = $logoPath;
        }

        // Update data tenant
        $tenant->tenant_name = $request->tenant_name;
        $tenant->category_name = $request->category_name;
        $tenant->nama_bank = $request->nama_bank;
        $tenant->rekening = $request->rekening;
        $tenant->alamat = $request->alamat;
        $tenant->save();

        return redirect()->route('dashboard.tenant.setting')->with('success', 'Data tenant berhasil diperbarui!');
    }

    public function history()
    {
       $inactiveTenant = Tenant::whereDoesntHave('transaksi', function($query) {
            $query->where('status', 'success');
        })->with('user')->get();

        return view('admin.tenanthist', compact('inactiveTenant'));
    }

    public function show($id, Request $request)
    {
        dd($id);
        $tenant = Tenant::with(['user'])->findOrFail($id);
        $from = $request->query('from', 'active');
        return view('admin.detailTenant', compact('tenant', 'from'));
    }

    public function setting()
    {
        $user = Auth::user();

        $tenant = Tenant::with('user')->where('user_id', $user->id)->firstOrFail();
        return view('tenant.setting', compact('tenant'));
    }

}
