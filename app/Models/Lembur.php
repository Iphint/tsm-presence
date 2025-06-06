<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tanggal',
        'start_lembur',
        'selesai_lembur',
        'salary_lembur',
        'action',
        'tugas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
