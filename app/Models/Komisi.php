<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komisi extends Model
{
    use HasFactory;

    protected $table = 'komisi'; // Nama tabel di database

    protected $fillable = [
        'bulan', 
        'staff_id'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function referal(){
        return $this->belongsTo(Referal::class, 'referal_id');
    }

    public function detailKomisi()
    {
        return $this->hasMany(DetailKomisi::class);
    }

    public function transaksi()
    {
        return $this->hasManyThrough(
            Transaksi::class,       // model tujuan akhir
            DetailKomisi::class,    // model penghubung
            'komisi_id',            // foreign key di detail_komisi yang mengarah ke komisi
            'id',                   // foreign key di transaksi (primary key)
            'id',                   // local key di komisi (primary key)
            'transaksi_id'          // foreign key di detail_komisi yang mengarah ke transaksi
        );
    }

}
