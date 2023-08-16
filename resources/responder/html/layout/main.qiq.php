{{ use
    Argo\Sapi\Http\Action\Config\GetConfig,
    Argo\Sapi\Http\Action\Get,
    Argo\Sapi\Http\Action\Import\GetImport,
    Argo\Sapi\Http\Action\Tags\GetTags,
    Argo\Sapi\Http\Action\Pages\GetPages,
    Argo\Sapi\Http\Action\Posts\GetPosts,
    Argo\Sapi\Http\Action\Sites\GetSites
}}
{{ response()->setHeader('content-type', 'text/html') }}
<!DOCTYPE html>
<html lang="en">
<head>
  {{= meta (charset: 'utf-8') }}
  {{= meta (name: "viewport", content: "width=device-width, initial-scale=1") }}
  {{= meta (http_equiv: "x-ua-compatible", content: "ie=edge") }}

  <title>{{h "Argo : {$header}" }}</title>

  {{= linkStylesheet ("/plugins/fontawesome-free/css/all.css") }}
  {{= linkStylesheet ("/dist/css/adminlte.css") }}
  {{= linkStylesheet ("https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700") }}
  {{= linkStylesheet ("/style.css") }}

  {{= script ("/scripts.js") }}

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo
    <a href="index3.html" class="brand-link">
      <img src="/dist/img/AdminLTELogo.png" alt="Argo Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Argo</span>
    </a>
    -->

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{a action (Get::CLASS) }}" class="nav-link">
              <p>Dashboard</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{a action (GetPosts::CLASS) }}" class="nav-link">
              <p>Posts</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{a action (GetPages::CLASS) }}" class="nav-link">
              <p>Pages</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{a action (GetTags::CLASS) }}" class="nav-link">
              <p>Tags</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{a action (GetConfig::CLASS, 'general') }}" class="nav-link">
              <p>General Config</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{a action (GetConfig::CLASS, 'theme') }}" class="nav-link">
              <p>Theme Config</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{a action (GetConfig::CLASS, 'menu') }}" class="nav-link">
              <p>Menu Config</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{a action (GetConfig::CLASS, 'blogroll') }}" class="nav-link">
              <p>Blogroll Config</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{a action (GetConfig::CLASS, 'featured') }}" class="nav-link">
              <p>Featured Config</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{a action (GetConfig::CLASS, 'sync') }}" class="nav-link">
              <p>Sync Config</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{a action (GetImport::CLASS) }}" class="nav-link">
              <p>Import</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{a action (GetSites::CLASS) }}" class="nav-link">
              <p>Sites</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">{{= $header ?? '' }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <p class="float-right">{{= anchorOpenFolder (
                $docroot,
                $docroot
            ) }}</p>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-12">
            {{= getContent() }}
          </div>

<!--
            <div class="card card-primary card-outline">
              <div class="card-body">
                <h5 class="card-title">Card title</h5>

                <p class="card-text">
                  Some quick example text to build on the card title and make up the bulk of the card's
                  content.
                </p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div>
-->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div><!-- /.content -->
  </div><!-- /.content-wrapper -->


  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Keep your content cancel-resistant.
    </div>
    <!-- Default to the left -->
    Copyright &copy; 2019-2021, Paul M. Jones. All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="/plugins/jquery/jquery.min.js"></script>

<!-- Bootstrap 4 -->
<script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AdminLTE App -->
<script src="/dist/js/adminlte.min.js"></script>

</body>
</html>
