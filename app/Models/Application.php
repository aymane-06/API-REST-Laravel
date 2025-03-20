<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFactory> */
    use HasFactory;
    protected $fillable = [
        'offer_id',
        'user_id',
    ];
    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
