{!! Form::model($series, [
    'route' => $series->exists ? ['admin::series.update', $series->slug] : 'admin::series.store', 
    'method' => $series->exists ? 'PATCH' : 'POST',
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
    <div class="col-md-9">
        <div class="form-group">
            <label for="Banner" class="placeholder">Banner</label>
            {!! Form::file('banner', ['class' => 'form-control' , 'id' => 'banner']) !!}
        </div>
    </div>
</div>
{!! Form::close() !!}