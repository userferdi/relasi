<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>@yield('title')</title>
    <meta name="description" content="Eloquent">
    <meta name="author" content="userferdi">

    {{-- CSRF TOKEN --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- CSS -->
    <link href="{{ asset('assets/bootstrap/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/datatables/datatables.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  </head>

  <body class="bg-light">
    <!-- Header Layout -->
		<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
	    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
	        <ul class="navbar-nav mr-auto">
	            <li class="nav-item {{ (request()->is('shop/product*')) ? 'active' : '' }}">
	                <a class="nav-link" href="{{ request()->is('shop/product*') ? '#' : route('product.index') }}">Product</a>
	            </li>
	            <li class="nav-item {{ (request()->is('shop/category*')) ? 'active' : '' }}">
	                <a class="nav-link" href="{{ route('category.index') }}">Category</a>
	            </li>
	            <li class="nav-item {{ (request()->is('shop/brand*')) ? 'active' : '' }}">
	                <a class="nav-link" href="{{ route('brand.index') }}">Brand</a>
	            </li>
	        </ul>
	    </div>
	    <a class="navbar-brand mx-auto" href="{{ request()->is('shop/product*') ? '#' : route('product.index') }}"><strong>PRINTG</strong></a>
	    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
	      <span class="navbar-toggler-icon"></span>
	    </button>
	    <div class="navbar-collapse collapse w-100 order-2 dual-collapse2">
	      <ul class="navbar-nav ml-auto">
  				<li class="nav-item dropdown">
  					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>
  					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
  						<a class="dropdown-item" href="#">Profile</a>
  						<a class="dropdown-item" href="#">Setting</a>
  						<div class="dropdown-divider"></div>
  						<a class="dropdown-item" href="#">Logout</a>
  					</div>
  				</li>
	      </ul>
	    </div>
		</nav>

    <!-- Container -->
    @yield('content')

<!-- <a href="#" id="pop">
    <img id="imageresource" src="http://patyshibuya.com.br/wp-content/uploads/2014/04/04.jpg" style="width: 400px; height: 264px;">
    Click to Enlarge
</a> -->

<!-- Creates the bootstrap modal where the image will appear -->
<!-- <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Image preview</h4>
      </div>
      <div class="modal-body">
        <img src="" id="imagepreview" style="width: 400px; height: 264px;" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div> -->

    <!-- Footer Layout -->
    <footer class="my-5 pt-5 text-muted text-center text-small">
      <p class="mb-1">&copy; 2020 Padjadjaran Laboratory</p>
      <ul class="list-inline">
        <li class="list-inline-item"><a href="#">Privacy</a></li>
        <li class="list-inline-item"><a href="#">Terms</a></li>
        <li class="list-inline-item"><a href="#">Support</a></li>
      </ul>
    </footer>

    <!-- Modal -->
    @include('modal')

    <!-- JavaScript -->
    <script src="{{ asset('assets/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert2/sweetalert2.all.js') }}"></script>
    @stack('scripts')
  </body>
</html>