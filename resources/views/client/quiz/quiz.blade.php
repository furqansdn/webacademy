@extends('client.layouts.app')

@section('content-header')
    <div class="content-header">

    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="#" method="POST" class="question-body" id="question-body">

                        </form>
                        {{-- <div class="card-title float-right">
                            <button disabled="disabled" class="btn btn-outline-primary ">Question 1</button>
                        </div>
                        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                        <div class="form-check">
                            <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="" id="" value="checkedValue" checked>
                            Display value
                          </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="" id="" value="checkedValue" checked>
                            Display value
                          </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="" id="" value="checkedValue" checked>
                            Display value
                          </label>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="" id="" value="checkedValue" checked>
                            Display value
                          </label>
                        </div> --}}
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <p class="card-title"><strong>Please Choose Answer Correcly!!</strong></p>
                        </div>
                        <div class="row mt-2 page-list">
                            @php
                                $i = 1 
                            @endphp
                            @foreach ($quiz->questions as $item)
                                @if ($item->users->isEmpty())
                                    <button class="btn btn-outline-primary mr-1 btn-question" data-question="question-{{$item->id}}" data-page="{{$i}}">{{$i++}}</button>
                                @else
                            <button class="btn btn-outline-primary mr-1 btn-question bg-teal" data-question="question-{{$item->id}}" data-page="{{$i}}">{{$i++}}</button>
                                @endif
                            @endforeach
                        </div>
                        <div class="row mt-2">
                            <div class="col">
                                <a class="btn btn-md bg-indigo btn-submit float-right" href="{{route('client::quiz.question.finish', $quiz->id )}}">Finish</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>

        function renderQuestionOption(option, answer, question) {
            const selected = (option.question_id === answer.question_id && option.mark_code === answer.mark_code) ? 'checked' : 'jancuk';

            return `
                <div class="form-check">
                    <label class="form-check-label" for="question_option-${option.id}"></label>
                    <input type="radio" class="form-check-input question_option" name="question_option" id="question_option-${option.id}" value="${option.mark_code}" ${selected} data-question="${question}">
                    ${option.option_text}
                </div>
            `;
        }
        function renderQuestion(question) {  
            
            const userAnswer = !question.data[0].users[0] ? '' : question.data[0].users[0].pivot;
            const markup = `
                <div class="card-title float-right">
                    <button disabled="disabled" class="btn btn-outline-primary ">Question ${question.current_page}</button>
                </div>
                <p class="card-text">${question.data[0].question}</p>
                ${question.data[0].question_options.map(el => renderQuestionOption(el, userAnswer,question.data[0].id)).join('')}
            `
            document.querySelector('.question-body').insertAdjacentHTML('beforeend', markup);
            
        }

        function getQuestion(page = 1) {
            const route = "{{route('client::quiz.question', ['quiz' => $quiz->id, 'page' => ''])}}"
            const url = route + page;
            $.ajax({
                url: url,
                success: function (response) {
                    renderQuestion(response)   
                }
            });
           
            
        }

        window.addEventListener('load', getQuestion);

        
        document.querySelector('.question-body').addEventListener('click', function (e) {  
            if (e.target.matches('.question_option')) {
                const val = e.target.value;
                const question = e.target.dataset.question;
                attachUserQuestion(val,question);
            }
            
        })
        
        function attachUserQuestion(val, question) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method:"POST",
                url: "{{route('client::quiz.question.answer')}}",
                data: {answer: val, question: question},
                success: function (response) {
                    console.log(response);
                    document.querySelector(`.btn-question[data-question='question-${response.id}']`).classList.add('bg-teal');
                }
            });
        }

        document.querySelector('.page-list').addEventListener('click', function (e) {  
            console.log(e.target);
            if (e.target.matches('.btn-question')) {
                const page = e.target.dataset.page;
                document.querySelector('.question-body').innerHTML = '';
                getQuestion(page);
            }
        })

    </script>
@endpush