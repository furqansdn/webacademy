<?php

namespace App\Http\Controllers\Client;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Membership\Plan;
use App\Models\Payment\Invoice;
use App\Models\Payment\Payment;
use App\Http\Controllers\Controller;
use App\Models\Membership\Subscription;
use App\Http\Resources\SubscriptionResource;
use App\Http\Requests\Client\PaymentConfirmationRequest;
use DataTables;


class SubscriptionController extends Controller
{
    public function plan()
    {
        $plans = Plan::all();
        return view('client.subscription.plan',compact('plans'));
    }

    public function generateInvoice(Plan $plan)
    {
        return view('client.subscription.invoice', compact('plan'));
    }
    
    public function proceed(Request $request, Plan $plan)
    {
        $this->validate($request,[
            'paymentMethod' => 'required',
        ]);

        $code = $this->generateSubscribedCode($plan->id);
        $randomNum = substr($code,4,3);
        $amount = $plan->price - $randomNum;

        if ($request->paymentMethod == 'transfer') {
            $subscription = Auth::user()->subscriptions()->create([
                'plan_id' => $plan->id,
                'subscription_code' => $code, //Generate Unique berdasarkan plan id
                'start_at' => Carbon::now(),
                'end_at' => Carbon::now()->Add($plan->month_of_subscription * 31,'day'),
                'isPaid' => false
            ]);
            $subscription->invoice()->create([
                'amount' => $amount,
                'expired' => Carbon::now()->Add(2,'hour')
            ]);

            return redirect()->route('client::subscription.checkout', $subscription->subscription_code);
        }
    }

    public function checkout(Subscription $subscription)
    {
        $subscription = new SubscriptionResource($subscription);
        return view('client.subscription.checkout', compact('subscription'));
    }

    public function paymentConfirmation()
    {
        $payment = new Payment();
        return view('client.subscription.paymentConfirmationForm',compact('payment'));
    }

    public function paymentConfirmationStore(PaymentConfirmationRequest $request)
    {
        $subscription = Subscription::where('subscription_code', $request->subscription_code)->first();

        if (!$subscription) {
            return response()->json([
                'message' => 'Nomor Invoice tidak tidak ditemukan, pastikan nomor sudah tepat atau pesanan tidak expired',
                'state' => 'no-data'
            ], 500);
        }
        $receipt = $request->payment_receipt->store('receipt');
        
        $data =$subscription->invoice->payment()->create([
            'paid_at' => date('yy-m-d', strtotime($request->paid_at)),
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'payment_receipt' => $receipt,
        ]);

        return response()->json([
            'message' => 'Berhasil memasukkan data, silahkan tunggu 1x24 jam konfimasi pesanan', 
        ], 200);
    }

    public function generateSubscribedCode($planId)
    {
        $plan = Plan::findOrFail($planId);
        $currentDate = Carbon::now();
        $randNumber = sprintf("%03d",rand(1,999));
        $code = $currentDate->format('ym').$randNumber;
        $getLastCode = Subscription::where('subscription_code', 'LIKE', '%'.$code.'%')->max('subscription_code');
        $nourut = (int) substr($getLastCode,9,3);
        $nourut++;
        $subscribedCode = $code.sprintf("%03d",$nourut);
        return $subscribedCode;
    }

    public function purchaseList()
    {
        return view('client.subscription.purchaseList');
    }

    public function purchaseListData()
    {
        $query = Subscription::where('user_id', Auth::user()->id)->latest()->get();
        return DataTables::of($query)
                ->addColumn('action', function($q){
                    if (!$q->invoice->payment || $q->invoice->payment->isConfirm == 0) {
                        return view('client.subscription._action', [
                            'url_edit' => route('client::subscription.paymentConfirmation'),
                            'title' => "Payment Konfirmation $q->subscription_code"
                        ]);
                    } elseif ($q->invoice->payment->isConfirm == 1) {
                        return '';
                    }
                })
                ->addColumn('status', function($q){
                    if (!$q->invoice->payment) {
                        return 'Belum Upload Konfirmasi Pembayaran';
                    } elseif ($q->invoice->payment->isConfirm == 0) {
                        return 'Menunggu Konfirmasi';
                    } elseif ($q->invoice->payment->isConfirm == 1) {
                        return 'Sudah Di Konfirmasi';
                    }
                })
                ->addIndexColumn()->rawColumns(['action','status'])->make(true);
    }

    public function confirmationForm()
    {
        $payment = new Payment();
        return view('client.subscription.formConfirmation',compact('payment'));
    }
}
