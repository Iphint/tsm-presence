<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Presence extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id', 'datang', 'pulang', 'location', 'status', 'keterangan','image'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'pulang' => $this->pulang,
            'user_name' => $this->user->name,
            'outlet_cabang' => $this->user->outlet_cabang
        ];
    }
}
