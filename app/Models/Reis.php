<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reis extends Model
{
    protected $table = 'reizen';
    protected $fillable = ['title', 'description', 'price', 'start_date', 'end_date'];

    public function boekingen()
    {
        return $this->hasMany(Boeking::class);
    }
}
