@extends('client.layouts.app')

@section('content')
<div class="container dashboard">
    <div class="row clearfix">
        <div class="col-md-3 p-5">
            <img src="https://img.icons8.com/color/1600/circled-user-male-skin-type-1-2.png" alt="" class="rounded-circle" style="height:200px; width:200px">
        </div>
        <div class="col-md-9 p-5">
            <div class="d-flex justify-content-between align-items-baseline pt-3">
                <h3>Client</h3>
                {{-- <a href="#" class="btn btn-success">Edit Profile</a> --}}
            </div>
            @if (Auth::user()->isSubscribed() > 0)
                <span>Premium</span>
            @else 
                <a href="#">Want Subscribe?</a>
            @endif
            <hr>
            <div class="pt-1"> 
                <div>
                <div class="level">Level {{ $level->level }} <span class="point float-right">{{$point}}/{{$next->min_point}}</span></div>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: {{$progress}}%; background:#6c5ce7;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{$progress}}%</div>
                  </div>
                </div>
                <div class="float-right" style="color: #ff7675"> <i class="fas fa-heart"></i>{{ Auth::user()->userLikes() }}</div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card p-5">
                <h3>My Latest Course</h3>
                <div class="row course mt-3">
                    @foreach ($latestcourse as $item)
                        <div class="col-md-4 mt-2">
                            <div class="card h-100">
                                <div class="card-header">
                                    <img src="{{asset($item->banner)}}" alt="course">
                                </div>
                                <div class="card-body">
                                    <div class="title">
                                        <a href="{{route('client::series.show', $item->slug)}}">{{$item->title}}</a>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar course-bar" role="progressbar" style="width: {{$item->userProgress()}}%; background:#6c5ce7;" aria-valuenow="{{$item->userProgress()}}" aria-valuemin="0" aria-valuemax="100">{{$item->userProgress()}}%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-md-12">
            <div class="card p-5">
                <h3>My Latest Discussion</h3>
                <div class="row discussion">
                    @foreach ($latestdiscussion as $item)
                    <div class="col-md-12">
                        <div class="card discussion-card">
                            <div class="card-body">
                                <a href="{{route('discussion.show', $item->slug )}}">{{Str::limit($item->title, 100, '...')}}</a>
                                <p>{!!Str::limit(strip_tags($item->body), 150, '. . .')!!}</p>
                            </div>
                            <div class="card-footer">
                                <div class="float-left">
                                    <p>{{$item->user->name}} <span class="timestamp">{{ $item->created_at->diffForHumans() }}</span></p>
                                </div>
                                <div class="float-right">
                                    <i class="far fa-comment"></i>{{$item->total_replies}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
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

