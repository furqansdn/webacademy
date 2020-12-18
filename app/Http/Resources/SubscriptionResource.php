<?php

namespace App\Http\Resources;

use App\Http\Resources\InvoiceResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status = '';
        if (!$this->invoice->payment) {
            $status = 'Pending';
        } elseif ($this->invoice->payment->isConfirm == 0) {
            $status = 'Waiting Confirmation';
        } elseif ($this->invoice->payment->isConfirm == 1) {
            $status = 'Confirm';
        }
        return [
            'subscription_code' => $this->subscription_code,
            'plan' => $this->plan,
            'invoice' => $this->invoice, 
            'status' => $status,
            'user_mail' => $this->user->email,
        ];
    }
}
