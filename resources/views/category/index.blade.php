@extends('layout')

@section('title','Home')

@section('content')
<div class="panel panel-primary">
  <div class="panel-heading">
    <h4 class="panel-title mb-3">Product
      <a href="{{ route('product.create') }}" class="btn btn-success float-right modal-show" title="Create Product"><i class="icon-plus"></i> Create</a>
    </h4>
  </div>
  <div class="panel-body">
    <table id="product_table" class="row-border compact order-column" style="width:100%">
      <thead>
        <tr>
          <th>No</th>
          <th>Category</th>
          <th>Product</th>
          <th>Option</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<script>
  $('#product_table').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: "{{ route('product.dt') }}",
    order: [[ 1, "desc" ]],
    columns: [
      {data: 'DT_RowIndex', name: 'no', orderable:false, width: '7.5%', className: 'dt-center'},
      {data: 'name', name: 'name', width: '20', className: 'dt-head-center'},
      {data: 'category_id', name: 'category', width: '20', className: 'dt-head-center'},
      {data: 'brand_id', name: 'brand', width: '20%', className: 'dt-head-center'},
      {data: 'updated_at', name: 'updated_at', width: '20%', className: 'dt-head-center'},
      {data: 'action', name: 'action', width:'12.5%', className: 'dt-center'}
    ],
  });

  $('body').on('click', '.modal-show', function(event){
    event.preventDefault();

    var me = $(this),
      url = me.attr('href'),
      title = me.attr('title');

    $('#modal-title').text(title);
    $('#modal-close').text(me.hasClass('edit') ? 'Cancel' : 'Close');
    $('#modal-save').text(me.hasClass('edit') ? 'Update' : 'Create');

    $.ajax({
      url: url,
      dataType: 'html',
      success: function (response) {
        $('#modal-body').html(response);
      }
    });

    $('#modal').modal('show');
  });
</script>
@endpush