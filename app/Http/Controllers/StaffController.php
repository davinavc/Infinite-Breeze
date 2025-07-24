<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function index()
    {
        $staffList = Staff::with('departemen')->where('status', '!=', 'Resign')->get();
        return view('admin.staff', compact('staffList'));
    }

    // Menampilkan form tambah staff
    public function create()
    {
        $departments = Department::where('status', 'Active')->get(); // ambil semua data departemen
        return view('admin.addstaff', compact('departments'));
    }

    // Menyimpan data staff ke database
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:6',
            'nm_depan'      => 'required|max:25',
            'nm_blkg'       => 'required|max:50',
            'birth_date'    => 'required|date',
            'no_telp' => ['required', 'regex:/^[0-9]+$/', 'digits_between:10,14'],
            'alamat'        => 'required|max:100',
            'dpt_id'        => [
                'required',
                Rule::exists('department', 'id')->where(function ($query) {
                    return $query->where('status', 'Active');
                }),
            ],
            'referral_code'  => 'required|max:30',
            'status'        => 'required|in:Volunteer,Staff,Manager,Resign',
            'tgl_exit'      => 'nullable|date',
            ], [
                    'no_telp.digits_between' => 'Nomor telepon harus terdiri dari minimal 10 dan maksimal 14 angka.',
                    'no_telp.regex' => 'Nomor telepon hanya boleh berisi angka.',
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'no_telp'  => $request->no_telp,
            'role'     => 'Staff',
        ]);

        Staff::create([
            'user_id'       => $user->id,
            'nm_depan'      => $request->nm_depan,
            'nm_blkg'       => $request->nm_blkg,
            'birth_date'    => $request->birth_date,
            'no_telp'       => $request->no_telp,
            'alamat'        => $request->alamat,
            'dpt_id'        => $request->dpt_id,
            'referral_code' => strtoupper($request->referral_code),
            'status'        => $request->status,
            'tgl_exit'      => $request->tgl_exit,
            'created_at'    => $request->created_at ?? now(),
        ]);

        return redirect()->route('dashboard.admin.staff')->with('success', 'Staff berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $staff = Staff::with('user')->findOrFail($id);
        $departments = Department::where('status', 'Active')->get();
        return view('admin.editStaff', compact('staff', 'departments'));
    }

    public function update(Request $request)
    {

        //  dd($request->all());
        $staff = Staff::with('user')->find($request->id);

        if (!$staff) {
            return redirect()->back()->with('error', 'Staff tidak ditemukan!');
        }

        // dd($staff->user);
        $request->validate([
            'id' => 'required|exists:staff,id',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($staff->user->id),
            ],
            'nm_depan' => 'required|max:25',
            'nm_blkg' => 'nullable|max:50',
            'birth_date' => 'required|date',
            'no_telp' => ['required', 'regex:/^[0-9]+$/', 'digits_between:10,14'],
                ], [
                    'no_telp.digits_between' => 'Nomor telepon harus terdiri dari minimal 10 dan maksimal 14 angka.',
                    'no_telp.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'alamat' => 'required|max:100',
            'dpt_id' => 'required|exists:department,id',
            'status' => 'required|in:Volunteer,Staff,Manager,Resign',
            'tgl_exit' => 'nullable|date',
        ]);
        
        // Update email ke model user
        $user = $staff->user;
        $user->email = $request->email;
        $user->no_telp = $request->no_telp;
        $user->save();

        $tgl_exit = $staff->status !== 'Resign' && $request->status === 'Resign' ? now() : $staff->tgl_exit;
        
        $staff->update([
            'nm_depan' => $request->nm_depan,
            'nm_blkg' => $request->nm_blkg,
            'birth_date' => $request->birth_date,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
            'dpt_id' => $request->dpt_id,
            'status' => $request->status,
            'tgl_exit' => $tgl_exit,
        ]);


        if (auth()->user()->role == 'Admin') {
            return redirect()->route('dashboard.admin.staff')->with('success', 'Data staff berhasil diperbarui');
        } else {
            return redirect()->route('dashboard.staff.setting')->with('success', 'Profil berhasil diperbarui');
        }
    }

    public function history()
    {
        $resignedStaff = Staff::with(['user', 'departemen'])
                            ->where('status', 'Resign')
                            ->get();

        return view('admin.staffhist', compact('resignedStaff'));
    }

    public function show($id, Request $request)
    {
        $staff = Staff::with(['user', 'departemen'])->findOrFail($id);
        $from = $request->query('from', 'active');
        return view('admin.detailStaff', compact('staff', 'from'));
    }

    public function setting()
    {
        $user = Auth::user();

        $staff = Staff::with('user')->where('user_id', $user->id)->firstOrFail();
        $departments = Department::where('status', 'Active')->get();

        return view('staff.setting', compact('staff', 'departments'));
    }
}
