<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;

class PaymentConfirmationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subscription_code' => 'required',
            'paid_at' => 'required',
            'bank_name' => 'required',
            'account_name' => 'required',
            'amount' => 'required',
            'payment_receipt' => 'required|image|max:2048'
        ];
    }
}
