<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalStaff extends Model
{
    use HasFactory;

    protected $table = 'jadwal_staff';

    protected $fillable = [
        'event_id',
        'tgl_event',
        'maks_staff',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function registrasi()
    {
        return $this->hasMany(StaffJadwalRegistrasi::class, 'jadwal_staff_id');
    }
}
