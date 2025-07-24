<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function edit()
    {
        $admin = auth()->user();
        if ($admin->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }
        return view('admin.setting', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        
        $admin = User::findOrFail($id); // Temukan admin berdasarkan id

        // Pastikan yang login adalah admin yang sama dengan id yang ingin diperbarui
        if (auth()->user()->id !== $admin->id || auth()->user()->role !== 'Admin') {
            abort(403, 'Unauthorized');
        }

        // Validasi input data
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'no_telp' => ['required', 'regex:/^[0-9]+$/', 'digits_between:10,14'],
                ], [
                    'no_telp.digits_between' => 'Nomor telepon harus terdiri dari minimal 10 dan maksimal 14 angka.',
                    'no_telp.regex' => 'Nomor telepon hanya boleh berisi angka.',
        ]);

        // Update data admin
        $admin->email = $validated['email'];
        $admin->no_telp = $validated['no_telp'];
        $admin->save();

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        // Redirect ke halaman setting setelah update selesai
        return redirect()->route('dashboard.admin.setting')->with('success', 'Data Admin berhasil diperbarui.');
    }
}
