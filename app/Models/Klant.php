<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klant extends Model
{
    protected $table = 'klanten';
    protected $fillable = ['name', 'email', 'phone', 'address'];

    public function boekingen()
    {
        return $this->hasMany(Boeking::class);
    }
}
