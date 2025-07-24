<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RegistrasiTenant;

class RegistrasiTenantController extends Controller
{
    public function indexAdmin()
    {
        $registrations = RegistrasiTenant::with(['event', 'tenant'])
            ->where('status', 'Pending')
            ->get();
            
        return view('admin.registration', compact('registrations'));
    }

    public function viewadmin()
    {
        $registrations = RegistrasiTenant::with(['event', 'tenant'])->get();
        return view('admin.viewRegist', compact('registrations'));
    }

    public function accept($id)
    {
        $reg = RegistrasiTenant::findOrFail($id);
        $reg->status = 'Confirmed';
        $reg->save();

        $registrations = RegistrasiTenant::with(['event', 'tenant'])->get();

        return view('admin.viewRegist', compact('registrations'))->with('success', 'Registrasi berhasil dikonfirmasi.');
    }

    public function reject($id)
    {
        $reg = RegistrasiTenant::findOrFail($id);
        $reg->status = 'Rejected';
        $reg->save();

        $registrations = RegistrasiTenant::with(['event', 'tenant'])->get();
        return view('admin.viewRegist', compact('registrations'))->with('success', 'Registrasi berhasil dikonfirmasi.');
    }

    public function showRegistrations()
    {
        $tenantId = auth()->user()->tenant->id;

        $registrations = RegistrasiTenant::with('event')
            ->where('tenant_id', $tenantId)
            ->get();

        return view('tenant.registration', compact('registrations'));
    }

    public function confirm($id)
    {
        $tenantId = auth()->user()->tenant->id;

        // Cek apakah tenant sudah pernah registrasi ke event ini (dengan status apapun)
        $pernahDitolak = RegistrasiTenant::where('event_id', $id)
            ->where('tenant_id', $tenantId)
            ->where('status', 'Rejected')
            ->exists();

        if ($pernahDitolak) {
            return redirect()->route('dashboard.tenant.registration')->with('error', 'Kamu sudah pernah ditolak untuk event ini, tidak bisa daftar lagi.');
        }

        $totalCancel = RegistrasiTenant::where('event_id', $id)
            ->where('tenant_id', $tenantId)
            ->where('status', 'Cancelled')
            ->count();

        if ($totalCancel >= 2) {
            return redirect()->route('dashboard.tenant.registration')->with('error', 'Kamu sudah membatalkan registrasi 2 kali untuk event ini, tidak bisa daftar lagi.');
        }


        // Jika belum pernah, buat registrasi baru
        RegistrasiTenant::create([
            'event_id' => $id,
            'tenant_id' => $tenantId,
            'status' => 'Pending',
        ]);

        return redirect()->route('dashboard.tenant.registration')->with('success', 'Berhasil registrasi. Tunggu konfirmasi admin.');
    }

    public function cancel($id)
    {
        $tenantId = auth()->user()->tenant->id;

        // Cari berdasarkan ID dari registrasi, bukan event
        $registrasi = RegistrasiTenant::where('id', $id)
            ->where('tenant_id', $tenantId)
            ->first();

        if ($registrasi) {
            $registrasi->status = 'Cancelled'; // Pastikan enum-nya sesuai dengan yang di DB
            $registrasi->save();
            return back()->with('error', 'Registrasi berhasil dibatalkan.');
        }

        return back()->with('error', 'Registrasi tidak ditemukan.');
    }

    public function show($id, Request $request)
    {
        $regist = RegistrasiTenant::findOrFail($id);
        $from = $request->query('from', 'active');
        $user = Auth::user();

        $role = strtolower($user->role);

        if ($role === 'admin') {
            $tenant = $regist->tenant;
            $event = $regist->event;
            return view('admin.detailRegist', compact('regist', 'tenant', 'event', 'from'));
        } elseif ($role === 'tenant') {
            return view('tenant.detailRegist', compact('regist', 'from'));
        }

        abort(403, 'Akses tidak diizinkan.');
    }

}

