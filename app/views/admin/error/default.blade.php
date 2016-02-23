<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> @yield('title') </title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

        <!-- Bootstrap 3.3.5 -->
        {{HTML::style('admin/bootstrap/css/bootstrap.min.css') }}
        </head>
        <!-- Font Awesome -->
        {{HTML::style('admin/dist/css/font-awesome.min.css') }}
        <!-- Ionicons -->
        {{HTML::style('admin/dist/css/ionicons.min.css') }}
        <!-- Theme style -->
        {{HTML::style('admin/dist/css/AdminLTE.min.css') }}
        <!-- AdminLTE Skins. Choose a skin from the css/skins
        folder instead of downloading all of them to reduce the load. -->
        {{HTML::style('admin/dist/css/skins/_all-skins.min.css') }}

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      @include('admin.common.navbar')

      <!-- Left side column. contains the logo and sidebar -->
      @include('admin.common.sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            @yield('title')
          </h1>
          <!-- <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol> -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Content -->
            @yield('content')
            <!-- ./ content -->
        </section>
        <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.0.0
        </div>
        <strong>Copyright &copy; 2015</strong>
      </footer>

    </div>
    <!-- ./wrapper -->

        <!-- jQuery 2.1.4 -->
        {{ HTML::script('admin/plugins/jQuery/jQuery-2.1.4.min.js') }}
        <!-- Bootstrap 3.3.5 -->
        {{ HTML::script('admin/bootstrap/js/bootstrap.min.js') }}
        <!-- AdminLTE App -->
        {{ HTML::script('admin/dist/js/app.min.js') }}
    </body>
</html>