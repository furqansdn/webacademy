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
    <div class="row mb-3">
        {{-- <div class="col-md-3"></div> --}}
        <div class="col-md-12 pr-0 pl-0">
            <form action="" class="form-inline float-left" method="GET">
                <input type="text" class="form-control" placeholder="What you looking for?" name="query">
                <button type="submit" class="btn btn-primary">Go</button>
            </form>
            @auth
                <a class="btn btn-success float-right" href="{{route('discussion.create')}}">Ask!</a>
            @endauth
        </div>
    </div>
    <div class="row mb-1">
        <div class="col-md-12">
            @foreach ($discussion as $item)
                <div class="row discussion">
                    <div class="col-md-12">
                        <div class="card discussion-card">
                            <div class="card-body">
                                <a href="{{route('discussion.show', $item->slug )}}">{{Str::limit($item->title, 100, '...')}}</a>
                                <p>{!!Str::limit(strip_tags($item->body), 150, '. . .')!!}</p>
                            </div>
                            <div class="card-footer">
                                <div class="float-left">
                                    <p>{{$item->user->name}} <span class="timestamp">{{$item->created_at->diffForHumans()}}</span></p>
                                </div>
                                <div class="float-right">
                                    <i class="far fa-comment"></i><span>{{$item->total_replies}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('css\custom.css')}}">
@endpush