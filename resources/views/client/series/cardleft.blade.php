<div class="col-md-4">
    <div class="card text-left">
      <div class="card-body">
        <div class="info-box bg-purple">
            <div class="info-box-content">
                <blockquote class="quote-secondary bg-purple">
                    <span class="lead"><i class="fas fa-video"></i><strong> {{ $series->lessons->count() }}</strong> Videos </span> <br>
                    <span class="lead"><i class="fas fa-edit"></i><strong> {{ $series->countQuiz() }}</strong> Quis Available </span>
                </blockquote>
            </div>
        </div>
        @if ($series->quizzes)
            <a href="{{route('client::quiz.list', $series->slug)}}" class="btn btn-md bg-teal">Go to Quiz</a>
        @endif

        @if ($series->userProgress() == 100)
            <a href="{{route('client::series.certificate', $series->slug)}}">Download Certificate</a>
        @endif
      </div>
    </div>
</div>