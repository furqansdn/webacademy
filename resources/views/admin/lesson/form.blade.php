{!! Form::model($lesson, [
    'route' => $lesson->exists ? ['admin::lesson.update', $series->slug, $lesson->id] : ['admin::lesson.store', $series->slug], 
    'method' => $lesson->exists ? 'PATCH' : 'POST',
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
    <div class="col-md-12">
        <div class="form-group">
            <label for="Description" class="placeholder">Description</label>
            {!! Form::textarea('description', null, ['class' => 'form-control' , 'id' => 'description']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="Episode" class="placeholder">Episode</label>
            {!! Form::number('episode_number', null, ['class' => 'form-control', 'id' => 'episode_number']) !!}
        </div> 
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="isPremium" class="placeholder">Premium Lesson</label>
            {!! Form::select('isPremium', [true=> 'Premium', false => 'Free'], null, ['class' => 'form-control', 'id' => 'isPremium']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-9">
        <div class="form-group">
            <label for="Video" class="placeholder">Video</label>
            {!! Form::file('video_path', ['class' => 'form-control' , 'id' => 'video_path']) !!}
        </div>
    </div>
</div>

<div class="progress">
    <div class="progress-bar bg-primary progress-bar-striped" role="progressbar"
          aria-valuemin="0" aria-valuemax="100" style="width: 0%">
      {{-- <span class="sr-only">40% Complete (success)</span> --}}
    </div>
</div>
{!! Form::close() !!}