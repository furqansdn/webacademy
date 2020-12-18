{!! Form::model($quiz, [
    'route' => $quiz->exists ? ['admin::quiz.update', $series->slug, $quiz->id] : ['admin::quiz.store', $series->slug], 
    'method' => $quiz->exists ? 'PATCH' : 'POST',
]) !!}
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="Title" class="placeholder">Title</label>
            {!! Form::text('title',null, ['class' => 'form-control' , 'id' => 'title']) !!}
        </div>
    </div>
</div>

<div class="row">
    {{-- <div class="col-md-6">
        <div class="form-group">
            <label for="Episode" class="placeholder">Time Limit</label>
            {!! Form::number('time_limit', null, ['class' => 'form-control', 'id' => 'time_limit', 'placeholder' => 'Minutes']) !!}
        </div> 
    </div> --}}
    <div class="col-md-12">
        <div class="form-group">
            <label for="Episode" class="placeholder">Mark Per Question</label>
            {!! Form::number('score_per_question', 1, ['class' => 'form-control', 'id' => 'score_per_question']) !!}
        </div> 
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="Description" class="placeholder">Description</label>
            {!! Form::textarea('description', null, ['class' => 'form-control' , 'id' => 'description']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::checkbox('is_premium', true, ['class' => 'form-control', 'id' => 'is_premium']) !!}
            <label for="is_premium," class="form-check-label">Is this quiz Premium ?</label>
        </div>
    </div>
</div>





{!! Form::close() !!}