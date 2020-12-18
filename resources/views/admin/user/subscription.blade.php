@extends('admin.layouts.app')

@section('content')
    <div class="card card-solid">
        <div class="card-body p-5">
            <div class="row justify-content-between mb-3">
                <h3>Table Konfirmasi Pembayaran Client</h3>
                {{-- <button href="{{route('admin::plan.create')}}" class="btn btn-outline-success modal-show" title="Create New Plan">Create Plan</button> --}}
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table text-center table-hover" id="dataTables">
                        <thead>
                            <tr>
                                <th style="width:10px">No</th>
                                <th>Email</th>
                                <th>Subscription Code</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        @php
                            $no = 1;
                        @endphp
                        <tbody>
                            @foreach ($subscription as $item)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$item->user->email}}</td>
                                    <td>{{$item->subscription_code}}</td>
                                    <td>{{$item->plan->name}}</td>
                                    <td>{{'Rp.'.$item->invoice->amount}}</td>
                                    <td class="state">{{$item->status}}</td>
                                    <td>
                                            <button class="btn btn-outline-primary btn-detail" href="{{route('admin::user.subscription.detail', $item->subscription_code)}}" title="{{"Detail Invoice " . $item->subscription_code}}"><i class="fas fa-search"></i></button>
                                        @if (!$item->invoice->payment)
                                            <button class="btn btn-outline-secondary" disabled><i class="fas fa-engine-warning"></i></button>
                                        @elseif($item->invoice->payment->isConfirm == 0)
                                            <button class="btn btn-outline-warning btn-confirmation" href="{{ route('admin::user.subscription.confirm', $item->subscription_code) }}" ><i class="fas fa-exclamation-triangle"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('.btn-confirmation').click(function (event) {  
            event.preventDefault();
            var me,url,row,text;

            // row = $(this).closest("tr"); 
            // row.find(".state").text("Confirmed");
            // $(this).remove();
            me = $(this);
            url = me.attr('href');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: "PATCH",
                url: url,
                success: function (response) {
                    row = me.closest("tr");
                    row.find(".state").text("Confirmed");
                    me.remove();
                    console.log(response);
                    
                },
                error: function (xhr) {  
                    console.log(xhr);
                }
            });
        });

        $('body').on('click', '.btn-detail', function (event) {
            event.preventDefault();

            var me = $(this),
                url = me.attr('href'),
                title = me.attr('title');

            $('#modalTitle').text(title);
            $('#modalBtnSave').hide();

            $.ajax({
                url: url,
                dataType: "html",
                success: function (response) {
                    $('#modalBody').html(response);
                }
            });

            $('#modalLarge').modal('show');
        });
    </script>
@endpush