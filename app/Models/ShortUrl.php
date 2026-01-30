<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShortUrl extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
       'user_id',
       'code',
       'original_url'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
