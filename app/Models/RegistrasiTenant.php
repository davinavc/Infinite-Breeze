<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrasiTenant extends Model
{
    use HasFactory;

    protected $table = 'registrasi_tenant';

    protected $fillable = [
        'tenant_id',
        'event_id',
        'status',
    ];

    // Relasi ke Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'tenant_id', 'tenant_id')
                    ->where('event_id', $this->event_id);
    }
}
