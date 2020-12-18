@extends('admin.layouts.app')

@section('content')
    <div class="card card-solid">
        <div class="card-body p-5">
            <div class="row justify-content-between mb-3">
                <h3>Table Of Plan</h3>
                <button href="{{route('admin::plan.create')}}" class="btn btn-outline-success modal-show" title="Create New Plan">Create Plan</button>
            </div>
            <div class="row">
                <div class="col-md-12">
                <table class="table text-center table-hover" id="dataTables">
                    <thead>
                        <tr>
                            <th style="width:10px">No</th>
                            <th>Name</th>
                            <th>Month of Subcription</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/Helper/modal.js') }} "></script>
<script src="{{ asset('js/Helper/ajax-cu.js') }} "></script>
<script>
    $('#dataTables').DataTable({
        responsive:true,
        processing:true,
        serverSide:true,
        ajax:"{{ route('admin::plan.data' )}}",
        columns:[
            {data:'DT_RowIndex', name:'id'},
            {data:'name', name:'name'},
            {data:'month_of_subscription', name:'month_of_subcription'},
            {data:'price', name:'price'},
            {data:'action', name:'action',searchable:false,orderable:false}
        ]
    });
    
</script>
@endpush

@push('style')
<link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endpush
