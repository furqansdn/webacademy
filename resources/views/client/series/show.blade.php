@extends('client.layouts.app')


@section('content-header')
    <section id="showcase" class="pb-5">
        <div class="primary-overlay text-white">
          <div class="container">
            <div class="row py-5">
              <div class="col-lg-6 text-center">
                <h1 class="display-4">
                  {{ $series->title}}
                </h1>
                
                <p class="lead">{{ $series->description }}</p>
                @if (Auth::user()->isSeriesTaken($series->slug) == 0)
                    <a href="{{ ($series->lessons->count() > 0) ? route('client::series.learning',[$series->slug,$series->getFirstLessonId()->id])  : '#' }}" class="btn btn-outline-primary btn-lg text-white"><i class="fa fa-play-circle"></i> Start Learning
                    </a>
                @elseif(Auth::user()->isSeriesTaken($series->slug) == 1)
                    <a href="{{ ($series->lessons->count() > 0) ? route('client::series.learning',[$series->slug,$series->getFirstLessonId()->id])  : '#' }}" class="btn btn-outline-primary btn-lg text-white"><i class="fa fa-play-circle"></i> Continue Learning
                    </a>
                @endif
              </div>
              <div class="col-lg-6 pl-5">
                <img src="{{ $series->banner }}" alt="" class="img-fluid d-none d-lg-block rounded">
              </div>
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

@push('style')
    <style>
        .primary-overlay {
            background: linear-gradient(315deg, #7f53ac 0%, #647dee 74%);
        }
    </style>
@endpush