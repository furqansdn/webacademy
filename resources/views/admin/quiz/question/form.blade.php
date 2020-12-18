{!! Form::model($question, [
    'route' => $question->exists ? ['admin::question.update', $quiz->id, $question->id] : ['admin::question.store', $quiz->id], 
    'method' => $question->exists ? 'PATCH' : 'POST',
]) !!}

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="question" class="placeholder">Question</label>
            {!! Form::textarea('question', null, ['class' => 'form-control', 'id' => 'question']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="question_image" class="placeholder">Question Image</label>
            {!! Form::file('question_image', ['class' => 'form-control' , 'id' => 'question_image']) !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="correct_answer" class="placeholder">Correct Answer</label>
            {!! Form::text('correct_answer', null, ['class' => 'form-control' , 'id' => 'correct_answer']) !!}
        </div>
    </div>
</div>


<div class="row d-flat mb-2">
    <label for="question_option" class="mr-2">Question Option</label></br> 
</div>

<div class="row">
    <div class="col-md-1">
        <div class="form-group">
            <input type="text" name="question_option[]"  class="form-control question_option" value="A" disabled>
        </div>
    </div>
    <div class="col-md-11">
        <div class="form-group">
            <input type="text" name="option_text[]"  class="form-control option_text">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-1">
        <div class="form-group">
            <input type="text" name="question_option[]"  class="form-control question_option" value="B" disabled>
        </div>
    </div>
    <div class="col-md-11">
        <div class="form-group">
            <input type="text" name="option_text[]"  class="form-control option_text">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-1">
        <div class="form-group">
            <input type="text" name="question_option[]"  class="form-control question_option" value="C" disabled>
        </div>
    </div>
    <div class="col-md-11">
        <div class="form-group">
            <input type="text" name="option_text[]"  class="form-control option_text">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-1">
        <div class="form-group">
            <input type="text" name="question_option[]"  class="form-control question_option" value="D" disabled>
        </div>
    </div>
    <div class="col-md-11">
        <div class="form-group">
            <input type="text" name="option_text[]"  class="form-control option_text">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="answer_explanation" class="placeholder">Answer Explanation</label>
            {!! Form::textarea('answer_explanation', null, ['class' => 'form-control', 'id' => 'answer_explanation']) !!}
        </div>
    </div>
</div>

{!! Form::close() !!}