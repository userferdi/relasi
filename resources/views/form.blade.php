{!! Form::model($model, [
    'route' => request()->is('shop/category*') ? ($model->exists ? ['category.update', $model->id] : 'category.store') : ($model->exists ? ['brand.update', $model->id] : 'brand.store'),
    'method' => $model->exists ? 'PUT' : 'POST',
    'class' => 'needs-validation form',
    'novalidate'
]) !!}

            <div class="modal-header">
                <h5 class="modal-title" id="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="" class="control-label">Name</label>
                    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter category', 'required']) !!}
                    <div class="invalid-feedback" id="invalid">Please fill out this field</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="modal-close"></button>
                <button type="submit" class="btn btn-primary" id="modal-save"></button>
            </div>

{!! Form::close() !!}