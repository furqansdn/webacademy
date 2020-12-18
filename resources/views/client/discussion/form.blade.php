@extends('client.layouts.app')

@section('content-header')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1>Discussion</h1>
      <p class="lead">Feel free to ask something</p>
    </div>
</div>
@endsection

@section('content')  
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-sm-6">
            <div class="card">
                <div class="card-header discussion-header">
                    <h3 class="card-title">Discussion Form</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('discussion.store')}}" id="discussion-form" method="POST">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" id="title" class="form-control">
                        </div>

                        <div class="form-group">
                            <textarea class="textarea" placeholder="Place some text here"
                          style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="body"></textarea>
                        </div>
                    </form>
                </div>
                <div class="card-footer discussion-footer">
                    <button class="btn btn-purple btn-block" id="btnSave">Post Discussion</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <style>
        .discussion-header {
            color: #fff;
            background: #6c5ce7;
            
        }
        .discussion-header h3{
            font-weight: 600;
        }

        .discussion-footer {
            background: #ffff !important;
            padding: 5px;
        }

        .btn-purple {
            display: block;
            color: #fff;
            background: #6c5ce7;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid #6c5ce7;

        }

        .btn-purple:hover {
            color: #6c5ce7;
            background: #fff;
            border: 2px solid #6c5ce7;
        }


    </style>
@endpush

@push('script')
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        $(function () {
            $('.textarea').summernote({
                height: 300
            });
        });

        $('#btnSave').click(function(event){
            event.preventDefault();
            var form = $('#discussion-form'),
                url = form.attr('action'),
                method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';
            var formData = new FormData(form[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: 'POST',
                url:url,
                data:formData,
                cache:false,
                contentType:false,
                processData:false,
                success: function (response) {
                    Swal.fire({
                        position: 'Center',
                        icon: 'success',
                        title: 'Yes Saved',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(()=> {
                        window.location.href = "{{ route('discussion.index') }}"
                    })
                },
                error: function (xhr) {
                    var res = xhr.responseJSON;
                    if ($.isEmptyObject(res) == false) {
                        $.each(res.errors, function (key, value){
                            $('#' + key)
                                .closest('.form-control')
                                .addClass('is-invalid')
                                .after('<small class="error invalid-feedback">' + value + '</small>')
                        });
                        console.log(res);
                    }
                }
            });
        })
    </script>
@endpush