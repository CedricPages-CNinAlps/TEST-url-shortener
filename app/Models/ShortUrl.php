<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShortUrl extends Model
{
    use HasFactory;

    protected $fillable = [
       'user_id',
       'code',
       'original_url'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
