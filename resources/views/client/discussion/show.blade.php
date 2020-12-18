@extends('client.layouts.app')


@section('content')  
<div class="container discussion-content">
    <div class="row mb-4">
        <div class="col-md-12 col-sm-6 discussion">
            <div class="discussion-title">
                <h1>{{ $discussion->title }}</h1>
            </div>
            <div class="discussion-meta clearfix">
                <span class="asked-by float-left">{{$discussion->user->name}}</span>
                <span class="posted-at float-right">{{ $discussion->created_at->diffForHumans()}}</span>
            </div>
            <hr>

            <div class="discussion-body">
                {!!$discussion->body!!}
            </div>

        </div>
        <div class="col-md-12 col-sm-6 mt-3">
            @auth                
                <div class="discussion-footer float-right">
                    <button class="btn btn-purple btn-reply">Reply <i class="fas fa-reply"></i></button>
                </div>
            @endauth
        </div>

    </div>
<div class="col-md-12" id="reply">
    @foreach ($discussion->replies as $item)
    
    <div class="row">
        <div class="col-md-12 col-sm-6">
            <div class="card clearfix">
                <div class="card-header">
                    <div class="reply-meta-user float-left">{{$item->user->name}}</div>
                    <div class="reply-meta-date float-right">{{$item->created_at->diffForHumans()}}</div>
                </div>
                <div class="card-body">
                    {!!$item->body!!}
                </div>
                <div class="card-footer">
                    @auth
                        @if (Auth::user()->isLiked($item->id) == 1)
                            <button type="button" class="btn btn-tool float-right btnLikes" data-reply="{{$item->Like}}" data-url="{{ route('reply.like', $item->id) }}"><i class="fas fa-heart fa-2x"></i></button>
                        @elseif(Auth::user()->isLiked($item->id) == 0)
                            <button type="button" class="btn btn-tool float-right btnLikes" data-reply="{{$item->Like}}" data-url="{{ route('reply.like', $item->id) }}"><i class="far fa-heart fa-2x"></i></button>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
    @endforeach 
</div>

    @auth       
        <div class="row" id="reply-form">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" id="btnClose"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <form action="{{route('reply.store', ['discussion' => $discussion->slug ])}}" method="POST">
                        <div class="form-group">
                            <textarea class="textarea" placeholder="Place some text here"
                                    style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="body"></textarea>
                        </div>  
                        <button class="btn btn-purple btn-block" id="saveReply">Reply <i class="fas fa-reply"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @endauth
</div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">

    <style>
        .discussion-content {
            padding: 30px 0;
        }

        .discussion-title h1 {
            font-size: 35px;
            font-weight: 400;
        }
        .discussion {
            padding: 20px 25px;
            border-radius: 20px;
            box-shadow: 5px 5px 20px #b2bec3;
        }
        .btn-purple {
            display: block;
            color: #fff;
            background: #6c5ce7;
            font-weight: 600;
            padding: 10px 20px;
            transition: all 0.3s ease;
            border: 2px solid #6c5ce7;
        }

        .btn-purple:hover {
            color: #6c5ce7;
            background: #fff;
            border: 2px solid #6c5ce7;
        }

        #reply-form {
            display: none;
        }

        .btnLikes{
            color: #ff7675;
        }

    </style>
@endpush

@push('script')
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script>
        $(function () {
            $('.textarea').summernote({
                height:150
            });
        });
        
        $('.btn-reply').click(function(event){
            event.preventDefault();

            var formReply = $('#reply-form');
            formReply.css({
                'display':'block'
            });

            $(this).css({
                'display':'none'
            })
        });

        $('#btnClose').click(function(event){
            event.preventDefault();
            var formReply = $('#reply-form');
            var replyBtn = $('.btn-reply');
            
            formReply.css({
                'display':'none'
            });
            
            replyBtn.css({
                'display':'block'
            });
        });

        $('#saveReply').click(function(event){
            event.preventDefault();

            var formReply = $('#reply-form');
            var replyBtn = $('.btn-reply');
            var reply = $('#reply');


            var form = $('#reply-form form'),
                url = form.attr('action'),
                method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';
            var formData = new FormData(form[0]);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: method,
                url:url,
                data:formData,
                cache:false,
                contentType:false,
                processData:false,
                success: function (response) {
                    $('.textarea').summernote('code', '');

                    let string = `
                    <div class="row">
                        <div class="col-md-12 col-sm-6">
                            <div class="card clearfix">
                                <div class="card-header">
                                    <div class="reply-meta-user float-left">${response.name}</div>
                                    <div class="reply-meta-date float-right">${response.created_at}</div>
                                </div>
                                <div class="card-body">
                                    ${response.body}
                                </div>
                                <div class="card-footer">
                                    <button type="button" class="btn btn-tool btnLikes float-right" data-url="${response.url}"><i class="far fa-heart fa-2x"></i></button> 
                                </div>
                            </div>
                        </div>
                    </div>
                    `;

                    formReply.css({
                        'display':'none'
                    });
                    
                    replyBtn.css({
                        'display':'block'
                    });

                    reply.append(string);

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
        });

        $('#reply').on('click', '.btnLikes',function (event){
            console.log(event);
            var url = $(this).data('url');
            var reply = $(this).data('reply');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(this).find('i').toggleClass('far fas');
            $.ajax({
                method: 'POST',
                url:url,
                success: function (response) {
                },
                error: function (xhr) {
                    console.log(xhr);
                }
            });
            
        })
    </script>
@endpush