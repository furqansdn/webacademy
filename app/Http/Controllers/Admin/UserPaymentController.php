<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Payment\Payment;
use App\Http\Controllers\Controller;

class UserPaymentController extends Controller
{
    public function index()
    {
        $payment = Payment::where('isConfirm', 1)->orderBy('paid_at','DESC')->get();
        $total = 0;
        foreach ($payment as $key) {
            $total += $key->invoice->amount;
        }
        
        return view('admin.user.userpayment',compact('payment','total'));
    }

}
