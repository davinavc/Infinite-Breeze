<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Referal;

class ReferalController extends Controller
{
    public function index()
    {
        $referals = Referal::with(['staff', 'tenant'])->get();
        return view('referal.index', compact('referals'));
    }
}
