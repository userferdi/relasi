{!! Form::model($model, [
    'route' => $model->exists ? ['shop.update', $model->id] : 'shop.store',
    'method' => $model->exists ? 'PUT' : 'POST'
]) !!}

    <div class="form-group">
        <label for="" class="control-label">Name</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
    </div>

    <div class="form-group">
        <label for="" class="control-label">Category</label>
        {!! Form::text('category_id', null, ['class' => 'form-control', 'id' => 'category_id']) !!}
    </div>

    <div class="form-group">
        <label for="" class="control-label">Brand</label>
        {!! Form::text('brand_id', null, ['class' => 'form-control', 'id' => 'brand_id']) !!}
    </div>

    <div class="form-group">
        <label for="" class="control-label">Price</label>
        {!! Form::text('price', null, ['class' => 'form-control', 'id' => 'price']) !!}
    </div>

    <div class="form-group">
        <label for="" class="control-label">Upload Image</label>
        {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
    </div>

{!! Form::close() !!}