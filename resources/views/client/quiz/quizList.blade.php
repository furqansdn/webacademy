@extends('client.layouts.app')

@section('content-header')
    <div class="content-header">

    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <img class="card-img-top" src="holder.js/100px180/" alt="">
                    <div class="card-body">
                        <h2>Quiz of {{$series->title}}</h2>
                        
                        <div class="list-group">
                            @foreach ($series->quizzes as $item)
                                <div class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{$item->title}}</h5>
                                        <small>{{$item->time_limit}} minutes</small>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <div>
                                            <p class="mb-1">{{$item->description}}</p>
                                            <small>Get {{$item->score_per_question}} score each question</small>
                                        </div>

                                        @if($item->user_quiz->isEmpty())
                                        <a href="{{route('client::quiz.start', ['series' => $series->slug , 'quiz' => $item->id])}}"><button class="btn btn-outline-info" >Start Quiz</button></a>
                                            
                                        @elseif ($item->user_quiz[0]->status == 0)
                                        <a href="{{route('client::quiz.continue', ['series' => $series->slug , 'quiz' => $item->id])}}"><button class="btn btn-outline-warning" >Ongoing</button></a>
                                        @elseif($item->user_quiz[0]->status == 1)
                                            <a href="{{route('client::quiz.start', ['series' => $series->slug , 'quiz' => $item->id])}}"><button class="btn btn-outline-success" >Score {{$item->user_quiz[0]->total_score}} | Start Over?</button></a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection