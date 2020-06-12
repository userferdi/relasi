{!! Form::model($model, [
    'route' => $model->exists ? ['category.update', $model->id] : 'product.store',
    'method' => $model->exists ? 'PUT' : 'POST',
    'class' => 'needs-validation form',
    'novalidate'
]) !!}
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="" class="control-label">Name</label>
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Category</label>
                    {!! Form::select('category', $model->category, $model->category_id, ['class' => 'form-control', 'id' => 'category_id']) !!}
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Brand</label>
                    {!! Form::select('brand', $model->brand, $model->brand_id, ['class' => 'form-control', 'id' => 'brand_id']) !!}
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Price</label>
                    {!! Form::text('price', null, ['class' => 'form-control', 'id' => 'price']) !!}
                </div>
                <div class="form-group">
                    <label for="" class="control-label">Upload Image</label>
                    {!! Form::text('image', null, ['class' => 'form-control', 'id' => 'image']) !!}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close"></button>
                <button type="submit" class="btn btn-primary" id="modal-save"></button>
            </div>

{!! Form::close() !!}