@extends('admin.layouts.app')

@section('content')
    <div class="card card-solid">
        <div class="card-body p-5">
            <div class="row mb-4">
                <div class="col-12">
                    <button class="btn btn-success float-right modal-show" href="{{route('admin::quiz.create', $series->slug)}}" title="Create New Quiz" id="new-quiz">Add New Quiz</button>
                </div>
            </div>
            <div class="row ">
                @foreach ($series->quizzes as $item)
                    <div class="col-md-6 col-sm-12">
                        <div class="card quiz-card">
                            <div class="card-header">
                                <h5 class="float-left">{{$item->title}}</h5> 
                                <p class="status float-left">
                                    @if ($item->is_premium)
                                        <span class="badge bg-teal">Premium</span>
                                    @else
                                        <span class="badge bg-info">Free</span>
                                    @endif
                                </p>

                                <h5 class="float-right"><i class="fas fa-hourglass-end"></i> {{$item->time_limit}} Minutes</h5>
                            </div>
                            <div class="card-body">
                                <p class="card-text">{{Str::limit($item->description,500)}}</p>
                            </div>
                            <div class="card-footer">
                                <a type="button" href="{{route('admin::question.index', $item->id)}}" class="btn btn-outline-primary btn-question float-left"><i class="fas fa-clipboard-list"></i>Go To Question</a>
                                <a type="button" class="btn btn-outline-danger btn-action float-right modal-delete" href="{{route('admin::quiz.destroy', [$series->slug, $item->id])}}"><i class="fas fa-trash"></i>Delete</a>
                                <a type="button" class="btn btn-outline-warning btn-action float-right modal-show" href="{{route('admin::quiz.edit', [$series->slug, $item->id])}}" title="{{'Edit '. $item->title}}"><i class="fas fa-edit"></i>Edit</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        #new-quiz {
            border-radius: 20px;
            font-weight: 600;
            transition: all 0.2s ease;
            padding: 8px 25px;
        }

        #new-quiz:hover {
            transform: scale(1.02);
        }
        .quiz-card {
            background: #9c88ff;
            color: #ffffff;
            box-shadow: 2px 4px 8px 0 #636e72;
            border-radius: 20px;
            min-height: 300px;
            transition: transform 0.1s ease-in
        }
        .quiz-card:hover {
            transform: scale(1.02);
        }

        .quiz-card .card-header {
            border-bottom: 1px solid #8e77ff
        }
        .quiz-card .card-header h5 {
            margin-right: 5px; 
            font-weight: 600
        }

        .quiz-card .card-footer .btn {
            border-radius: 20px;
            padding: 7px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .quiz-card .card-footer .btn i {
            margin-right: 5px
        }

        .quiz-card .card-footer .btn-action {
            margin-right: 5px;
        }


        .quiz-card .card-footer .btn-outline-primary {
            color: #ffffff;
            background: transparent;

            border: 2px solid #ffffff;
        }

        .quiz-card .card-footer .btn-outline-primary:hover {
            background: #2CB67D;
            color: #ffffff;
            border: 2px solid transparent;
        }

        .quiz-card .card-footer .btn-outline-danger {
            border: 2px solid #e17055;
        }

        .quiz-card .card-footer .btn-outline-danger:hover {
            background: #e17055;
            border: 2px solid transparent;
        }

        .quiz-card .card-footer .btn-outline-warning {
            border: 2px solid #fdcb6e;
        }

        .quiz-card .card-footer .btn-outline-warning:hover {
            background: #fdcb6e;
            border: 2px solid transparent;
        }



    </style>
@endpush

@push('script')
<script src="{{ asset('js/Helper/modal.js') }} "></script>
<script src="{{ asset('js/Helper/ajax-cu.js') }} "></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

@endpush