@extends('layout')

@section('title','Product - PRINTG')

@section('content')
<div style="margin-top: 5rem;" class="container-fluid">
  <div class="row">
    <div class="col-sm-3 order-sm-1 mb-3">
      <h4 class="d-flex justify-content-between align-items-center mb-3">Filter</h4>
      <ul class="list-group mb-3">
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">Category</h6>
            <small class="text-muted">a</small>
          </div>
          <span class="text-muted">b</span>
        </li>
        <li class="list-group-item d-flex justify-content-between lh-condensed">
          <div>
            <h6 class="my-0">Brand</h6>
            <small class="text-muted"></small>
          </div>
          <span class="text-muted"></span>
        </li>
      </ul>
    </div>
    <div class="col-sm-9 order-sm-2">
      <div class="card">
        <div class="card-body">
          <h4 class="panel-title"><strong>Product</strong>
            <a href="{{ route('product.create') }}" class="btn btn-outline-success float-right modal-show mb-2" name="Create Product"><i class="icon-plus"></i> Create</a>
          </h4>
          <table id="table" class="table row-border hover order-column" style="width:100%">
            <thead class="thead-light">
              <tr>
                <th>No</th>
                <th>Product</th>
                <th>Category</th>
                <th>Brand</th>
                <th>Update</th>
                <th>Image</th>
                <th>Option</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$("#pop").on("click", function() {
   $('#imagepreview').attr('src', $('#imageresource').attr('src')); // here asign the image to the modal when the user click the enlarge link
   $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
});

  function format (d) {
    return  '<div class="container" style="width:100%">'+
              // '<div class="row mb-2">'+
              //   '<label>Price'+'&emsp;'+':</label>'+
              //   '&emsp;'+
              //   '<div class="card">'+
              //       '<p class="card-text">'+'&nbsp;'+d.price+'&ensp;'+'</p>'+
              //   '</div>'+
              // '</div>'+
              // '<div class="row">'+
              //   '<label>Details'+'&nbsp;'+':</label>'+
              //   '&emsp;'+
              // '</div>'+
              // '<div class="card">'+
              //   '<div class="card-body">'+
              //     '<p class="card-text">'+d.details.details_1+'</br>'+d.details.details_2+'</p>'+
              //   '</div>'+
              '</div>'+


            '</br>';
                    // '<td>'+'<img src=/images/' + d.image + '>'+'</td>'+
  };

  var detail = $('#table').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: "{{ route('product.dt') }}",
    order: [[ 4, "desc" ]],
    columns: [
      {data: 'DT_RowIndex', name: 'no', orderable:false, width: '7%', className: 'dt-center'},
      {data: 'name', name: 'name', width: '19%', className: 'dt-head-center'},
      {data: 'category_id', name: 'category', orderable: false, width: '19%', className: 'dt-head-center'},
      {data: 'brand_id', name: 'brand', orderable: false, width: '19%', className: 'dt-head-center'},
      {data: 'updated_at', name: 'updated_at', width: '16%', className: 'dt-head-center'},
      {data: 'ibtn', name: 'ibtn', width: '10%', className: 'dt-center'},
      {data: 'action', name: 'action', orderable: false, width:'10%', className: 'dt-center'}
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

  $('#table tbody').on('click', '.details-control', function () {
    event.preventDefault();
    var tr = $(this).closest('tr');
    var row = detail.row( tr );

    if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
    }
    else {
        row.child( format(row.data()) ).show();
        tr.addClass('shown');
    }
  });

</script>
@endpush