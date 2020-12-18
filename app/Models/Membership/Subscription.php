<?php

namespace App\Models\Membership;

use App\User;
use App\Models\Payment\Invoice;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $guarded = [];
    protected $with = ['invoice','plan','user'];

    // Parameter menggunakan subscription_code bukan id
    public function getRouteKeyName()
    {
        return 'subscription_code';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function getStatusAttribute()
    {
        $status = '';
        if (!$this->invoice->payment) {
            $status = 'Pending';
        } elseif ($this->invoice->payment->isConfirm == 0) {
            $status = 'Waiting Confirmation';
        } elseif ($this->invoice->payment->isConfirm == 1) {
            $status = 'Confirmed';
        }
        return $status;
    }
}
