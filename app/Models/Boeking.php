<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boeking extends Model
{
    protected $table = 'boekingen';
    protected $fillable = ['user_id', 'klant_id', 'reis_id', 'accommodatie_id', 'booking_date', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function klant()
    {
        return $this->belongsTo(Klant::class);
    }

    public function reis()
    {
        return $this->belongsTo(Reis::class);
    }

    public function accommodatie()
    {
        return $this->belongsTo(Accommodatie::class);
    }

    public function facturen()
    {
        return $this->hasMany(Factuur::class);
    }
}
