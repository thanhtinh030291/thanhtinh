<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <meta name="description" content="{{ config('app.name') }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('images/favicon.ico')}}">

    <!-- Bootstrap CSS -->
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Font Awesome CSS -->
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css" />

	<!-- Date range picker CSS -->
	<link href="{{asset('plugins/datetimepicker/css/daterangepicker.css')}}" rel="stylesheet" />
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/select2_optimize.css')}}" rel="stylesheet" type="text/css" />

    @yield('stylesheets')

</head>

<body class="adminbody">
    <div id="main">
        <!-- top bar navigation -->
        @include('layouts.admin.partials.top_bar_navigation')
        <!-- End Navigation -->
        <!-- Left Sidebar -->
        @include('layouts.admin.partials.left_sidebar')
        <!-- End Sidebar -->
        <div class="content-page">
            <!-- Start content -->
            <div class="content">
			    <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12">
                            @include('message.message')
                        </div>
                    </div>
                    @yield('content')
                </div>
            </div>
            <!-- END content -->
        </div>
        <!-- END content-page -->
        <!-- Start footer -->
        @include('layouts.admin.partials.footer')
        <!-- END footer -->
    </div>
    <!-- END main -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="{{asset('js/modernizr.min.js')}}"></script>
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/detect.js')}}"></script>
    <script src="{{asset('js/fastclick.js')}}"></script>
    <script src="{{asset('js/jquery.blockUI.js')}}"></script>
    <script src="{{asset('js/jquery.nicescroll.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/daterangepicker.js')}}"></script>
    <!-- App js -->
    <script src="{{asset('js/pikeadmin.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('.select2').select2();
        });
    </script>
    <!-- BEGIN Java Script for this page -->
    @yield('scripts')
    <!-- END Java Script for this page -->
</body>
</html>
