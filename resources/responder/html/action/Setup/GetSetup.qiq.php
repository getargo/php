{{ use Argo\Sapi\Http\Action\Setup\PostSetup }}
{{ setLayout (null) }}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Argo : Setup</title>

  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.css">
  <link rel="stylesheet" href="/dist/css/adminlte.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700">
  <link rel="stylesheet" href="/style.css">

  <script src="/scripts.js"></script>

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-lg-12">
            <h1 class="m-0 text-dark">Welcome to Argo!</h1>
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

            <p>
                Setup is a breeze: just enter a few pieces of information, and your local
                site will be working in no time!
            </p>

            <form onsubmit="return false;">
                <div class="row mb-1 align-items-start">
                    <div class="col col-2 text-right">
                        <label for="name">Folder Name</label>
                    </div>
                    <div class="col">
                        {{= textField (
                            name: 'name',
                            value: '',
                            class: 'form-control',
                        ) }}
                    </div>
                </div>

                <div class="row mb-1 align-items-start">
                    <div class="col col-2 text-right">
                        <label for="title">Blog Title</label>
                    </div>
                    <div class="col">
                        {{= textField (
                            name: 'title',
                            value: '',
                            class: 'form-control',
                        ) }}
                    </div>
                </div>

                <div class="row mb-1 align-items-start">
                    <div class="col col-2 text-right">
                        <label for="tagline">Blog Tagline</label>
                    </div>
                    <div class="col">
                        {{= textField (
                            name: 'tagline',
                            value: '',
                            class: 'form-control',
                        ) }}
                    </div>
                </div>

                <div class="row mb-1 align-items-start">
                    <div class="col col-2 text-right">
                        <label for="author">Author Name</label>
                    </div>
                    <div class="col">
                        {{= textField(
                            name: 'author',
                            value: $author,
                            class: 'form-control',
                        ) }}
                    </div>
                </div>

                <div class="row mb-1 align-items-start">
                    <div class="col col-2 text-right">
                        <label for="url">Site URL</label>
                    </div>
                    <div class="col">
                        {{= textField (
                            name: 'url',
                            value: '',
                            class: 'form-control',
                        ) }}
                    </div>
                </div>

                <div class="row mb-1 align-items-start">
                    <div class="col col-2 text-right">
                    </div>
                    <div class="col">
                        {{= submitAction (
                            'Create',
                            PostSetup::CLASS
                        ) }}&nbsp;<span id="submit-failure"></span>
                    </div>
                </div>
            </form>

          </div>
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
    Copyright &copy; 2019-2023, Paul M. Jones. All rights reserved.
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
