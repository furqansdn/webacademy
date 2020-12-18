<?php

namespace App\Models\Payment;

use App\Models\Payment\Payment;
use App\Models\Membership\Subscription;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];
    protected $with = ['payment'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
