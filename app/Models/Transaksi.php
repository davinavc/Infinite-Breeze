<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //
    protected $table = 'transaksi';

    protected $fillable = [
        'tenant_id',
        'event_id',
        'referral_staff_id',
        'papan_nama',
        'nama_pemesan',
        'watt_listrik',
        'listrik_24_jam',
        'bukti_transaksi',
        'total_price',
        'status',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'referral_staff_id');
    }
    
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function registrasi()
    {
        return $this->belongsTo(RegistrasiTenant::class, 'registrasi_id');
    }

    public function staffFollowUp()
    {
        return $this->belongsTo(Staff::class, 'follow_up_by');
    }

}
