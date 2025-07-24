<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

class DeptController extends Controller
{
    public function index()
    {
        $deptList = Department::all();
        return view('admin.departemen', compact('deptList'));
    }
    
    // Menampilkan form tambah staff
    public function create()
    {
        return view('admin.addDpt');
    }

    // Menyimpan data staff ke database
    public function store(Request $request)
    {
        $request->validate([
            'department' => 'required|string|max:100|unique:department,department',
        ]);

        Department::create([
            'department' => $request->department,
            'status' => 'Active',
        ]);

        return redirect()->route('dashboard.admin.dept')->with('success', 'Departemen berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('admin.editDept', compact('department'));
    }


    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:department,id',
            'department' => 'required|string|max:100',
        ]);

        Department::where('id', $request->id)->update([
            'department' => $request->department,
        ]);

        return redirect()->route('dashboard.admin.dept')->with('success', 'Department berhasil diupdate!');
    }

    public function toggleStatus($id)
    {
        $department = Department::findOrFail($id);
        $department->status = $department->status === 'Active' ? 'Inactive' : 'Active';
        $department->save();

        return redirect()->route('dashboard.admin.dept')->with('success', 'Status department berhasil diubah.');
    }

}
