@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3 ml-auto ">
        <div class="col-12">
            <button href="{{ route('admin::series.create') }}" class="btn btn-success float-right modal-show" title="Create New Series">New Series</button>
        </div>
    </div>
    <div class="row">
        @foreach ($series as $item)
        <div class="col-lg-3 mb-3">
            <div class="card h-100">
                <div class="card-header p-0">
                    <img src="{{ !$item->banner ? 'https://www.yudana.id/wp-content/uploads/2019/02/Vuejs.jpg' : asset($item->banner) }}" alt="" class="card-img-top" style="height:200px">
                </div>
                <div class="card-body">
                    <h5 class="card-title"><strong>{{$item->title}}</strong></h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">10 Video</li>
                    <li class="list-group-item">2 Hours</li>
                </ul>
                <div class="card-footer px-0">
                    <div class="col-12">
                        <a href="{{ route('admin::series.show', $item->slug) }}" class="btn btn-primary mr-auto"><i class="fas fa-book-open"></i>Lecture</a>

                        <a href="{{ route('admin::series.destroy', $item->slug) }}" class="btn btn-danger float-right modal-delete"><i class="fas fa-trash"></i> Delete</a>
                        <a href="{{ route('admin::series.edit', $item->slug) }}" class="btn btn-warning float-right modal-show edit"><i class="fas fa-edit"></i>Edit</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
        <!-- /.row -->
</div><!-- /.container-fluid -->
@endsection


@push('script')
    
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('js/Helper/modal.js') }} "></script>
<script src="{{ asset('js/Helper/ajax-cu.js') }} "></script>


<script type="text/javascript">
    $(document).ready(function () {
      bsCustomFileInput.init();
    });
</script>
    
@endpush

{{-- @push('style')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
@endpush --}}