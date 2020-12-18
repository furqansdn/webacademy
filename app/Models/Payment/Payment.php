<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $guarded = [];
    
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

}
