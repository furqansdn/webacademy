@extends('client.layouts.app')

@push('style')
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
@endpush


@section('content-header')
    <div class="content-header">
    </div>    
@endsection


@section('content')
<div class="container">
    <h1 class="display-4 text-center mb-2">Form Konfirmasi Pembayaran</h1>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="card card-solid ">
                <div class="card-body">
                    {!! Form::model($payment, [
                        'route' => 'client::subscription.payment.store', 
                        'method' => 'POST',
                    ]) !!}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="subscription_code" class="placeholder">Kode Invoice</label>
                                {!! Form::number('subscription_code', null, ['class' => 'form-control', 'id' => 'subscription_code']) !!}
                            </div> 
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="paid_at" class="placeholder">Tanggal Bayar</label>
                                {!! Form::text('paid_at',null, ['class' => 'form-control' , 'id' => 'paid_at']) !!}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Description" class="placeholder">Nama Bank Pengirim</label>
                                {!! Form::text('bank_name', null, ['class' => 'form-control', 'id' => 'bank_name' ]) !!}
                            </div>
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Description" class="placeholder">Nama Pengirim</label>
                                {!! Form::text('account_name', null, ['class' => 'form-control', 'id' => 'account_name' ]) !!}
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="amount" class="placeholder">Total Transfer</label>
                                {!! Form::number('amount', null, ['class' => 'form-control', 'id' => 'amount']) !!}
                            </div> 
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="payment_receipt" class="placeholder">Payment Receipt</label>
                                {!! Form::file('payment_receipt', ['class' => 'form-control' , 'id' => 'payment_recipt']) !!}
                            </div> 
                        </div>
                    </div>
                    
                    {!! Form::close() !!}
                </div>
                <div class="card-action">
                    <a href="" class="btn btn-warning btn-block btn-confirm">Konfirmasi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('script')
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> --}}

    <script>
        $('#paid_at').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        })

        $('.btn-confirm').click(function (event) {  
            event.preventDefault();
            var form = $('.card-body form'),
                url = form.attr('action')

            var formData = new FormData(form[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            form.find('.invalid-feedback').remove();
            form.find('.form-control').removeClass('is-invalid');

            $.ajax({
                method: "POST",
                url: url,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {                    
                    Swal.fire({
                        position: 'Center',
                        icon: 'success',
                        title: 'Yes Saved',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(()=> {
                        window.location.href = "{{ route('client::series.list') }}"
                    })
                },
                error: function (xhr) {  
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        if (res.state === 'no-data') {
                            Swal.fire({
                                position: 'Center',
                                icon: 'error',
                                title: 'Gagal',
                                text:res.message,
                                timer: 5000
                            })
                        } else {
                            $.each(res.errors, function (key, value) {
                                $('#' + key)
                                    .closest('.form-control')
                                    .addClass('is-invalid')
                                    .after('<small class="error invalid-feedback">' + value + '</small>')
                            });
                            console.log(res);
                        }
                    }   
                }
            });
        });


    </script>
@endpush


