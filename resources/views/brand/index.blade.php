@extends('layout')

@section('title','Brand - PRINTG')

@section('content')
<div style="margin-top: 7.5rem;" class="container">
<div class="card">
  <div class="card-body">
    <h4 class="panel-title mb-3"><strong>Brand</strong>
      <a href="{{ route('brand.create') }}" class="btn btn-outline-success float-right modal-show" name="Create Brand"><i class="icon-plus"></i> Create</a>
    </h4>
    <table id="table" class="table row-border hover order-column" style="width:100%">
      <thead class="thead-light">
        <tr>
          <th>No</th>
          <th>Brand</th>
          <th>Product</th>
          <th>Option</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div>
</div>
</div>
@endsection

@push('scripts')
<script>
  $('#table').DataTable({
    responsive: true,
    serverSide: true,
    ajax: "{{ route('brand.dt') }}",
    order: [[ 1, "asc" ]],
    columns: [
      {data: 'DT_RowIndex', name: 'no', orderable:false, width: '10%', className: 'dt-center'},
      {data: 'name', name: 'name', width: '37.5%', className: 'dt-head-center'},
      {
        data: 'product',
        name: 'product.name',
        orderable:false,
        width: '37.5%',
        className: 'dt-head-center',
        render: function(data, type, row, full) {
          var txt = " ";
          data.forEach(function (item) {
            if (txt.length > 1) {
              txt += '</br> '
            }
            txt += item.name;
          });
          return txt
        }
      },
      {data: 'action', name: 'action', orderable:false, width:'15%', className: 'dt-center'}
    ],
  });

  $('body').on('click', '.modal-show', function(event){
    event.preventDefault();

    var me = $(this),
      url = me.attr('href'),
      title = me.attr('name');

    $.ajax({
      url: url,
      dataType: 'html',
      success: function (response) {
        $('#modal-body').html(response);
        $('#modal-title').text(title);
        $('#modal-close').text(me.hasClass('edit') ? 'Cancel' : 'Close');
        $('#modal-save').text(me.hasClass('edit') ? 'Update' : 'Create');
      }
    });

    $('#modal').modal('show');
  });

  $('body').on('submit','.form', function(event){
    event.preventDefault();

    var form = $('form'),
        url = form.attr('action'),
        method = $('input[name=_method]').val() == undefined ? 'POST' : 'PUT';

    $.ajax({
      url : url,
      method : method,
      data : form.serialize(),

      success: function(response){
        form.trigger('reset');
        $('#modal').modal('hide');
        $('#table').DataTable().ajax.reload();
        const Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          background: '#28a745',
          onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
        })
        Toast.fire({
          type: 'success',
          title: 'Data has been saved!'
        })
      },

      error: function(){
        var validation = Array.prototype.filter.call(form, function(form) {
          form.classList.add('was-validated');
        });
      }
    });
  });

  $('body').on('click', '.delete', function (event) {
    event.preventDefault();

    var me = $(this),
        url = me.attr('href'),
        name = me.attr('name'),
        csrf_token = $('meta[name="csrf-token"]').attr('content');

    swal({
      title: 'Are you sure want to delete ' + name + '?',
      text: "You won't be able to revert this!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result)=>{
      if(result.value){
        $.ajax({
          url: url,
          type: "POST",
          data: {
            '_method': 'DELETE',
            '_token': csrf_token
          },
          success: function(response){
            $('#table').DataTable().ajax.reload();
            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              background: '#BD362F',
              onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
              }
            })
            Toast.fire({
              type: 'success',
              text: 'Data has been deleted'
            })
          },
          error: function(xhr){
            swal({
              type: 'error',
              title: 'Oops...',
              text: 'Something went wrong!'
            });
          }
        });
      }
    });
  });

</script>
@endpush