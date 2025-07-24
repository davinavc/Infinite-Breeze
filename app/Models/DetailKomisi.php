<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKomisi extends Model
{
    use HasFactory;

    protected $table = 'detail_komisi';

    protected $fillable = [
        'komisi_id',
        'tenant_id',
        'transaksi_id',
        'total_komisi',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function komisi()
    {
        return $this->belongsTo(Komisi::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function jadwalStaff()
    {
        return $this->belongsTo(JadwalStaff::class, 'jadwal_staff_id');
    }


}
