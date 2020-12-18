<?php

namespace App\Http\Controllers\Admin;

use DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Membership\Subscription;
use App\Http\Resources\SubscriptionResource;

class SubscriptionController extends Controller
{
    public function userSubscription()
    {
        $subscription = Subscription::whereHas('invoice', function($query){
            $query->whereHas('payment');
        })->get();

        return view('admin.user.subscription',compact('subscription'));
    }

    public function userSubscriptionDetail(Subscription $subscription)
    {
        return view('admin.user.subscriptionDetail', compact('subscription'));
    }

    public function confirm(Request $request, Subscription $subscription )
    {
        if ($request->ajax()) {
            $subscription->isPaid = 1;
            $subscription->save();
            
            $subscription->invoice->payment->isConfirm = 1;
            $subscription->invoice->payment->save();
    
            return $subscription;
        }
    }



}
