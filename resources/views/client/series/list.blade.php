@extends('client.layouts.app')


@section('content-header')
<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <h1>Series List</h1>
      <p class="lead">Belajarlah seakan-akan kau hidup selamanya</p>
    </div>
</div>
@endsection
@section('content')  
<div class="container ">
    <div class="row course gap-5 justify-content-center clearfix">
        @foreach ($series as $item)
            <div class="col-md-4 mt-2">
                <div class="card h-100">
                    <div class="card-header">
                        <img src="{{asset($item->banner)}}" alt="course">
                    </div>
                    <div class="card-body">
                        <div class="title">
                            <a href="{{route('client::series.show', $item->slug)}}">{{$item->title}}</a>
                            <p>{{$item->countLecture()}} Lecture</p>
                        </div>
                        
                        <a href="{{ route('client::series.show', $item->slug) }}" class="btn btn-outline-primary">Learn</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{asset('css\custom.css')}}">
    <style>
        .dashboard {
            padding: 30px 0;
        }
    </style>
@endpush
