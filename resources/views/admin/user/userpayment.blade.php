@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card card-solid">
            <div class="card-body p-5">
                <div class="row justify-content-between mb-3">
                    <h3>Laporan Pembayaran</h3>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table text-center table-hover" id="dataTables">
                            <thead>
                                <tr>
                                    <th style="width:10px">No</th>
                                    <th>Email</th>
                                    <th>Plan</th>
                                    <th>Amount</th>
                                    <th>Tanggal Bayar</th>
                                </tr>
                            </thead>
                            @php
                                $no = 1;
                            @endphp
                            <tbody>
                                @foreach ($payment as $item)
                                    <tr>
                                        <td>{{$no++}}</td>
                                        <td>{{$item->invoice->subscription->user->email}}</td>
                                        <td>{{$item->invoice->subscription->plan->name}}</td>
                                        <td>Rp.{{$item->invoice->amount}}</td>
                                        <td>{{$item->paid_at}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row mt-5">
                    <strong>Total Pembayaran : Rp. {{$total}}</strong>
                </div>
            </div>
        </div>
    </div>
@endsection