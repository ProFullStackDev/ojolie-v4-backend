<!DOCTYPE html>
<html>
@include('layouts.head')
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  @include('layouts.header')
  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  @include('layouts.left-sidebar')

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @include('layouts.breadcrumb')
    <!-- Main content -->
    <section class="content">
      @include('layouts.message')
      @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('layouts.footer-copyright')

  <!-- Control Sidebar -->
  @include('layouts.right-sidebar')
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
@include('layouts.modals')
@include('layouts.footerScripts')
</body>
</html>
