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
                    <div class="card-body text-center">
                        <h2>Result</h2>
                        <h4>Total Score : {{ $quiz_progress->total_score }}</h4>
                        <a href="{{ route('home') }}" class="btn btn-success">Completed</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection