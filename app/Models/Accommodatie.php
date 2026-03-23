<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodatie extends Model
{
    protected $table = 'accommodaties';
    protected $fillable = ['name', 'location', 'type', 'price_per_night'];

    public function boekingen()
    {
        return $this->hasMany(Boeking::class);
    }
}
