<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AV Comparatives</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div id="app" class="wrapper">
        <!-- Main Header -->
        <main-header></main-header>
        <!-- Left side column. contains the logo and sidebar -->
        <side-menu></side-menu>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <router-view></router-view>
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                Developed by Stiff Roy
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2018 <a href="https://www.av-comparatives.org">AV Comparatives</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <control-sidebar></control-sidebar>
        <!-- /.control-sidebar -->
        <!-- Add the sidebar's background. This div must be placed
        immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <script src="{{ asset('/js/app.js') }}"></script>
</body>
</html>
