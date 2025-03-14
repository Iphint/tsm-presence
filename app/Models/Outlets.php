<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlets extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_outlet',
        'alamat'
    ];
    public function users()
    {
        return $this->hasMany(User::class, 'outlet_id');
    }
}
