<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kinerja extends Model
{
    use HasFactory;

    protected $table = 'kinerjas';

    protected $fillable = [
        'user_id',
        'tunjangan_jabatan',
        'tunjangan_masa_kerja',
        'potongan',
        'bulan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
