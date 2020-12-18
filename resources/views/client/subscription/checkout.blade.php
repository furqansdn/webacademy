@extends('client.layouts.app')

@section('content-header')
    <div class="content-header">

    </div>
@endsection


@section('content')
    <div class="container">
        <div class="card card-solid">
            <div class="card-body">
                <h1 class="display-4">Pesanan Berhasil!</h1>
                <p class="lead">Terima kasih karena sudah melakukan pembelian di platform kami, silahkan melakukan pembayaran senilai <strong>{{'Rp.'.$subscription->invoice->amount}}</strong> pada rekening yang tertera dibawah ini:</p>

                <table class="table table-bordered mb-3">
                    <thead>
                        <tr>
                            <th>Nama Bank</th>
                            <th>No Rekening</th>
                            <th>A.N</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Mandiri Syariah</td>
                            <td>709718103</td>
                            <td>MUHAMMAD FURQAN SOEDONO</td>
                        </tr>
                    </tbody>
                </table>

                <p style="border: 2px solid #ff851b; padding: 20px 30px; font-size: 18px;">
                    Untuk mempercepat proses verifikasi pembayaran, harap lakukan pembayaran dengan nominal tepat hingga tiga angka terakhir, yaitu: <strong>{{ 'Rp.'.$subscription->invoice->amount}}</strong>. Harap mencantumkan kode berlangganan ketika melakukan konfirmasi, <strong>Subscription Code : {{ $subscription->subscription_code}} </strong>
                    <br><br>
                    Harap lakukan pembayaran paling lambat <strong>2 Jam</strong> dari sekarang tepatnya pada <strong>{{ $subscription->invoice->expired }}</strong>, lewat dari waktu tersebut maka status pesanan akan expired, kamu harus melakukan pemesanan ulang.
                </p>

                <p class="lead">Setelah melakukan pembayaran harap segera lakukan konfirmasi pembayaran pada link yang tertera</p>
                <p class="lead">Untuk proses pembayaran manual melalui transfer bank, kami hanya melakukan pengecekan setelah kamu melakukan konfirmasi pembayaran. Oleh karena itu, pastikan untuk melakukan konfirmasi pembayaran setelah melakukan pembayaran.</p>
                <p class="lead">Jika kamu mengalami kesulitan dalam melakukan konfirmasi pembayaran dan aktivasi akun, kamu bisa menghubungi kami melalui WhatsApp atau telpon melalui <strong>081375118105</strong>. Kami akan dengan senang hati membantu. Terima kasih</p>

            </div>
            <div class="card-action">
                <a href="{{route('client::subscription.paymentConfirmation')}}" class="btn btn-warning btn-block" target="_blank">Konfirmasi</a>
            </div>
        </div>
    </div>
@endsection