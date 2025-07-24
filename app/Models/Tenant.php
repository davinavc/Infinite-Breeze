<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Transaksi;

class Tenant extends Model
{
    protected $table = 'tenant';

    protected $fillable = [
        'user_id',
        'tenant_name',
        'category_name',
        'alamat',
        'logo',
        'nama_bank',
        'rekening',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function registrations()
    {
        return $this->hasMany(RegistrasiTenant::class);
    }
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'tenant_id', 'id');
    }
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

}
