@extends('client.layouts.app')


@section('content-header')
    <section id="showcase" class="pb-5">
        <div class="primary-overlay text-white ">
          <div class="container">
            <div class="row pt-5">
                <div class="col-12">
                    @if ($lesson->getPreviusLesson())
                    <a class="btn btn-success float-left" href="{{route('client::series.learning',[$series->slug, $lesson->getPreviusLesson()->id])}}">Previus Lesson</a>
                    @endif
                    @if ($series->getNextLessons($lesson->episode_number))    
                        <a class="btn btn-success float-right" href="{{route('client::series.learning',[$series->slug, $series->getNextLessons($lesson->episode_number)->id])}}">Next Lessons</a>
                    @endif
                </div>
            </div>
            <div class="row pb-3">
              <div class="col-lg-12 d-flex justify-content-center">
                <video width="400" height="320" controls>
                    <source src="{{ route('storage.video', [$series->slug, $lesson->video_name])  }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
              </div>
            </div>
            <div class="row ">
                <div class="col-lg-12 text-center">
                <button class="btn btn-outline-success text-center" onclick="event.preventDefault();
                document.getElementById('mark-complete').submit();">Mark As Complete</button>
                    <h1 class="display-5">{{ $lesson->title }}</h1>
                    <p class="lead">{{$lesson->description}}</p>
                </div>
                <form id="mark-complete" action="{{ route('client::series.lesson.complete',[$series->slug,$lesson->id]) }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
          </div>
        </div>
    </section>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    @include('client.series.courselist')
                </div>
            </div>
            @include('client.series.cardleft')
        </div>
    </div>
@endsection

