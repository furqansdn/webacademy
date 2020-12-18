<div class="row">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td>Nama Bank Pengirim</td>
                <td>{{$subscription->invoice->payment->bank_name}}</td>
            </tr>
            <tr>
                <td>Nama Akun Pengirim</td>
                <td>{{$subscription->invoice->payment->account_name}}</td>
            </tr>
            <tr>
                <td>Tanggal Bayar</td>
                <td>{{$subscription->invoice->payment->paid_at}}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="row justify-content-center">
    <img src="{{route('admin::storage.receipt', $subscription->invoice->payment->payment_receipt)}}" alt="" srcset="" style="max-height: 450px;">
</div>