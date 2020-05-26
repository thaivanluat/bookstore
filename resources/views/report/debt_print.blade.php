<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title></title>
  <base href="{{asset('')}}">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">  
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet"> -->

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Page specific styles -->
  
    <style>
    * {
        font-family: "Dejavu Sans";
    }
    </style>
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <!-- Content Row -->
          <h6 class="m-0 font-weight-bold text-primary" style="text-align: center; text-transform: uppercase; padding-bottom: 20px;">{{ trans('report.debt_report_with_time', [ 'month' => $month, 'year' => $year]) }}</h6>
          <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>{{ trans('report.customer_name') }}</th>
                                <th>{{ trans('report.customer_phone') }}</th>
                                <th>{{ trans('report.customer_email') }}</th>
                                <th>{{ trans('report.opening_debt') }}</th>
                                <th>{{ trans('report.total_buy') }}</th>
                                <th>{{ trans('report.total_payment') }}</th>
                                <th>{{ trans('report.ending_debt') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                            <tr>
                                <th><a href="{{url('/customer/detail', [$item->makhachhang])}}">{{ $item->hoten }}</a></th>
                                <th>{{ $item->dienthoai }}</th>
                                <th>{{ $item->email }}</th>
                                <th>{{ $item->nodau }}</th>
                                <th>{{ $item->tongtienmua }}</th>
                                <th>{{ $item->tongtientra }}</th>
                                <th>{{ $item->nocuoi }}</th>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
          <!-- End Content Row -->
        </div>
        <!-- /.container-fluid -->

          
      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Bootstrap core JavaScript-->

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  
  <!-- Page specific scripts -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
</body>

</html>
