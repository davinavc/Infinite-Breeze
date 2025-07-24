<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffJadwalRegistrasi extends Model
{
    protected $table = 'staff_jadwal_registrasi';

    protected $fillable = [
        'staff_id',
        'jadwal_staff_id',
        'status',
    ];

    public function jadwalStaff()
    {
        return $this->belongsTo(JadwalStaff::class, 'jadwal_staff_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

}
