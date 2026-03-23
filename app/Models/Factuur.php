<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factuur extends Model
{
    protected $table = 'facturen';
    protected $fillable = ['boeking_id', 'invoice_number', 'amount', 'status', 'due_date'];

    public function boeking()
    {
        return $this->belongsTo(Boeking::class);
    }
}
