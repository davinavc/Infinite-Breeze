<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RegistrasiTenant;


class Event extends Model
{
    use HasFactory;

    protected $table = 'event';

    protected $fillable = [
        'event_name',
        'place',
        'theme',
        'start_date',
        'finish_date',
        'poster',
        'tenant_quota',
        'supported_electricity',
        'price_per_watt',
        'tm',
        'tm_link',
        'harga',
        'capital',
        'revenue',
    ];

    public function jadwalStaff(){
        return $this->hasMany(JadwalStaff::class, 'event_id');
    }

    public function registrations()
    {
        return $this->hasMany(RegistrasiTenant::class, 'event_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaksi::class);
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

}
