@extends('client.layouts.app')

@section('content-header')
    <div class="content-header">
        
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-solid p-3">
                    <div class="card-body">
                        <h3>Total Biaya</h3>
                        <p class="lead">Nama : {{Auth::user()->name}} <br> Email : {{Auth::user()->email}}</p>
                        
                        <table class="table table-striped text-right">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ 'Membership Paket ('.$plan->name.')' }}</td>
                                    <td>{{ 'Rp.'.$plan->price }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-solid">
                    <form action="{{ route('client::subscription.proceed', $plan->id) }}" method="POST">
                        @csrf
                        <div class="card-body">   
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" id="customRadio" name="paymentMethod" value="transfer" checked>
                                <label class="custom-control-label" for="customRadio">Transfer Manual</label><br>
                                <small>
                                    Pembayaran melalui transfer ke rekening kami di 
                                    <b>Bank Mandiri Syariah.</b> 
                                    Kami akan mengurangi harga total Kamu sebesar angka random antara 1 sampai 999 
                                    rupiah untuk mempermudahkan kami melakukan pengecekan pada saat melakukan verifikasi pembayaran
                                </small>
                            </div>
                        </div>
                        <div class="card-action">
                            <button class="btn btn-warning btn-block" type="submit"><strong>Lanjutkan</strong></button>    
                        </div>
                    </form>  
                </div>
            </div>
        </div>


    </div>
@endsection