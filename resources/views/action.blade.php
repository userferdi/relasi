<a href="{{ $show }}" class="modal-show" title="Details Product: {{ $model->name }}"><i class="icon-eye-open text-success"></i></a> | 
<a href="{{ $edit }}" class="modal-show edit" title="Edit Product: {{ $model->name }}"><i class="icon-pencil text-success"></i></a> | 
<a href="{{ $delete }}" class="delete" title="{{ $model->name }}"><i class="icon-trash text-danger"></i></a>