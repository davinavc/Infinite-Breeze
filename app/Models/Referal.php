<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referal extends Model
{
    use HasFactory;

    protected $table = 'referal'; // Nama tabel di database

    protected $fillable = ['staff_id', 'tenant_id', 'jumlah_terpakai'];

    public function staff(){
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function tenant(){
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function komisi(){
        return $this->hasMany(Komisi::class, 'referal_id');
    }
}
