<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Auto Generated Controller-Model-SqlFile-ApiDocument For Codeigniter">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Pavan Kumar">

  <title>{{ config('app.name', 'Codeigniter | Auto Generator') }}</title>

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Bootstrap core CSS-->
  <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="{{ asset('css/sb-admin.css') }}" rel="stylesheet">
  <link href="{{ asset('css/common_style.css') }}" rel="stylesheet">
  <!-- Jquery Js -->
  <script type="text/JavaScript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js" ></script>
  
</head>

<body class="fixed-nav sticky-footer bg-dark sidenav-toggled" id="page-top" style="background-color: white">
  
  <!-- Container -->
  <div class="content-wrapper">
    @yield('container')
    
    <!-- footer -->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
            <small style="color:white">Auto Generated Api's | Author: <a href="https://www.facebook.com/profile.php?id=100005175935690&amp;fref=ts"><em>Pavan Kumar</em></a></small>
        </div>
      </div>
    </footer>
    <!-- End of footer -->

    <!-- Scroll to Top Button -->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- End of scroll to top button -->
    
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('js/jquery.easing.min.js') }}" defer></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin.min.js') }}" defer></script>
    <script src="{{ asset('js/commom_script.js') }}" defer></script>
  </div>
  <!-- End of container -->

</body>
</html>