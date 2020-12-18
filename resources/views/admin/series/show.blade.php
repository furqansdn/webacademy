@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1 class="display-4 text-center">{{$series->title}}</h1>
            <hr class="my-4">
            <h4>{{ $series->description }}</h4>
        </div>
        <div class="row mb-3 ml-auto ">
            <div class="col-12 d-flex justify-content-between">
                <a href="{{ route('admin::quiz.index', $series->slug) }}" class="btn btn-success float-right" title="Create Lesson">Quiz</a>  
                <button href="{{ route('admin::lesson.create', $series->slug) }}" class="btn btn-success float-right modal-show" title="Create Lesson">Lesson</button>
            </div>
        </div>

        <div class="row">
            @foreach ($series->lessons as $lesson)
            <div class="col-12">
                <div class="card lesson">
                    <div class="card-body d-flex">
                        <div class="col-1">
                            <button disabled="disabled" class="btn btn-outline-primary"> {{$lesson->episode_number}} </button>
                        </div>
                        <div class="col-9 mt-1 ml-1">
                            <h4> {{ $lesson->title }} </h4>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-outline-warning modal-show edit" href="{{route('admin::lesson.edit', [$series->slug, $lesson->id])}}" title="{{'Edit Lesson '. $lesson->title }}">Edit</button>
                            <button class="btn btn-outline-danger modal-delete" href="{{route('admin::lesson.destroy', [$series->slug, $lesson->id])}}">Delete</button>
                        </div>
                    </div>
                  </div>
            </div>
            @endforeach
        </div>

    </div>
@endsection

@push('style')
    <style>
        .jumbotron {
            background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),url("{{ !$series->banner ? 'https://www.yudana.id/wp-content/uploads/2019/02/Vuejs.jpg' : asset($series->banner) }}");
            background-size: cover;
            color: #ffffff;
            border-radius: 25px;
            box-shadow: 2px 4px 8px 0 #797878;
            transform: scale(1);
            transition: all 0.3s ease
        }

        .jumbotron:hover {
            transform: scale(1.02);
        }

        .jumbotron h4 {
            font-size: 17px;
            line-height: 1.5;
        }

        .lesson {
            transition: transform 0.3s ease
        }
        .lesson:hover {
            transform: translate(15px, 0);
        }
    </style>
@endpush

@push('script')
    <script src="{{ asset('js/Helper/modal.js') }} "></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#modalBtnSave').click(function (event) {
                event.preventDefault();
                var form = $('#modalBody form'),
                    url = form.attr('action'),
                    method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';
                
                var formData = new FormData(form[0]);

                

                if (method == 'PUT') {
                    formData.append('_method', 'PATCH');
                }

                form.find('.form-text').remove();
                form.find('.form-group').removeClass('has-error');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $.ajax({
                    method: 'POST',
                    url: url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    xhr: function () {  
                        var jqXHR = null;
                        if ( window.ActiveXObject )
                        {
                            jqXHR = new window.ActiveXObject( "Microsoft.XMLHTTP" );
                        }
                        else
                        {
                            jqXHR = new window.XMLHttpRequest();
                        }

                        //Upload progress
                        jqXHR.upload.addEventListener( "progress", function ( evt )
                        {
                            if ( evt.lengthComputable )
                            {
                                var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                                //Do something with upload progress
                                $('#modalBody .progress-bar').css('width', percentComplete + '%');
                            }
                        }, false );

                        //Download progress
                        jqXHR.addEventListener( "progress", function ( evt )
                        {
                            if ( evt.lengthComputable )
                            {
                                var percentComplete = Math.round( (evt.loaded * 100) / evt.total );
                                //Do something with download progress
                                $('#modalBody .progress-bar').css('width', percentComplete + '%');
                            }
                        }, false );

                        return jqXHR;
                    },
                    success: function (response) {
                        
                        form.trigger('reset');
                        $('#modalLarge').modal('hide');

                        Swal.fire({
                            position: 'Center',
                            icon: 'success',
                            title: 'Yes Saved',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(()=> {
                            location.reload()
                        })
                        
                    },
                    error: function (xhr) {
                        var res = xhr.responseJSON;
                        if ($.isEmptyObject(res) == false) {
                            $.each(res.errors, function (key, value) {
                                $('#' + key)
                                    .closest('.form-control')
                                    .addClass('is-invalid')
                                    .after('<small class="error invalid-feedback">' + value + '</small>')
                            });
                            console.log(res);

                        }
                    }
                });
            });
        });
        
    </script>
@endpush