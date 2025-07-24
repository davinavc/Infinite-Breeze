<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Department;


class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $fillable = [
        'user_id',
        'nm_depan',
        'nm_blkg',
        'birth_date',
        'alamat',
        'no_telp',
        'dpt_id',
        'referral_code',
        'status',
        'tgl_exit',
        'created_at',
    ];

    public function departemen()
    {
        return $this->belongsTo(Department::class, 'dpt_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'referral_staff_id');
    }

    public function komisi()
    {
        return $this->hasMany(Komisi::class);
    }


}
