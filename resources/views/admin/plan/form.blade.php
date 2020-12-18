{!! Form::model($plan, [
    'route' => $plan->exists ? ['admin::plan.update', $plan->id ] : 'admin::plan.store', 
    'method' => $plan->exists ? 'PATCH' : 'POST',
]) !!}
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="name" class="placeholder">Name</label>
            {!! Form::text('name',null, ['class' => 'form-control' , 'id' => 'name']) !!}
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
            <label for="monthOfSubscription" class="placeholder">Month of Subcription</label>
            {!! Form::number('month_of_subscription', null, ['class' => 'form-control', 'id' => 'month_of_subcription']) !!}
        </div> 
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="Price" class="placeholder">Price</label>
            {!! Form::number('price', null, ['class' => 'form-control', 'id' => 'price']) !!}
        </div> 
    </div>
</div>

{!! Form::close() !!}