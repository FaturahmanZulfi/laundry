<?php 
  require('../koneksi.php');
  include('../function.php');
  session_start();
  if(!($_SESSION['role'] === 'admin')){
    header("Location:../../");
  }else{
    $nama = $_SESSION['nama'];
    $role = $_SESSION['role'];
  }

  if(ISSET($_POST['logout'])){
    session_destroy();
    header('Location:../../');
  }

  $sql = "SELECT paket.id,paket.nama_paket,paket.jenis,paket.harga,outlet.nama as outlet FROM paket INNER JOIN outlet ON paket.id_outlet = outlet.id";
  $records = mysqli_query($koneksi,$sql);

  if (ISSET($_POST['create'])) {
    $nama_paket = $_POST['namap'];
    $jenis = $_POST['jenisp'];
    $harga = $_POST['hargap'];
    $outlet = $_POST['outletp'];
    $table = 'paket';
    $field = ['id_outlet','jenis','nama_paket','harga'];
    $values = ["'$outlet'","'$jenis'","'$nama_paket'","'$harga'"];

    $create = create($table,$field,$values);
    if ($create) {
      header('Location:paket.php');
    }
  }
  
 ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Laundry - Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="../../vendor/font-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="../../datepicker/css/bootstrap-datepicker.min.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../../css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fa fa-hotel"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Laundry</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fa fa-dashboard"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Navigasi
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="member.php">
        <i class="fa fa-fw fa-users"></i>
        <span>Pelanggan/member</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="outlet.php">
        <i class="fa fa-fw fa-building"></i>
        <span>Outlet</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="paket.php">
        <i class="fa fa-fw fa-black-tie"></i>
        <span>Produk/paket cucian</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="user.php">
        <i class="fa fa-fw fa-user"></i>
        <span>Pengguna</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="entri_transaksi.php">
        <i class="fa fa-fw fa-book"></i>
        <span>Entri transaksi</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="generate_laporan.php">
        <i class="fa fa-fw fa-bar-chart"></i>
        <span>Generate Laporan</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          
          <h1>Paket</h1>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $role ?></span>
                <div class="topbar-divider d-none d-sm-block"></div>
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $nama ?></span>
                <!-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"> -->
                <i class="fa fa-user"></i>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                  </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->

          <div class="row">

            <div class="col-lg-12 mb-4">

              <!-- Approach -->
              
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Data Paket</h6>
                </div>
                <div class="card-body">

                  <a href="#" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#createModal">
                    <span class="icon text-white-100">
                      <i class="fas fa-plus"></i>
                    </span>
                    <span class="text">Tambah Data Paket</span>
                  </a>

                  <table class="table mt-3">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Paket</th>
                        <th scope="col">Jenis</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Outlet</th>
                        <th scope="col" colspan="2">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; foreach($records as $record) : ?>
                        <tr>
                          <th scope="row"><?= $no ?></th>
                          <td><?= $record['nama_paket'] ?></td>
                          <td><?= $record['jenis'] ?></td>
                          <td><?= $record['harga'] ?></td>
                          <td><?= $record['outlet'] ?></td>
                          <td>
                            <a href="edit_paket.php?id=<?= $record['id'] ?>" class="btn btn-warning btn-icon-split">
                              <span class="icon text-white-100">
                                <i class="fa fa-edit"></i>
                              </span>
                            </a>
                          </td>
                          <td>
                            <a href="delete_paket.php?id=<?= $record['id'] ?>" onclick="return confirm('anda yakin ingin menghapus data ini ?')" class="btn btn-danger btn-icon-split">
                              <span class="icon text-white-100">
                                <i class="fa fa-minus"></i>
                              </span>
                            </a>
                          </td>
                        </tr>
                      <?php $no++; endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
              

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; faturahman_zulfi 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <?php require('logout.php'); ?>

  <!-- Create Modal-->
  <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Tambah Data Paket</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST">
        <div class="modal-body">

          <div class="form-group row">
            <label for="namap" class="col-sm-2 col-form-label">Nama Paket</label>
            <div class="col-sm-10">
              <input type="text" name="namap" class="form-control" id="namap">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="inlineFormCustomSelectPreff">Jenis</label>
            <div class="col-sm-10">
              <select class="form-control" id="inlineFormCustomSelectPreff" name="jenisp">
                <option value="kiloan">Kiloan</option>
                <option value="selimut">Selimut</option>
                <option value="bed_cover">Bed Cover</option>
                <option value="kaos">kaos</option>
                <option value="lain">Lainr</option>
              </select>
            </div>
          </div>
          <div class="form-group row">
            <label for="hargap" class="col-sm-2 col-form-label">Harga</label>
            <div class="col-sm-10">
              <input type="text" name="hargap" class="form-control" id="hargap">
            </div>
          </div>
          <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="inlineFormCustomSelectPref">Outlet</label>
            <div class="col-sm-10">
              <select class="form-control" id="inlineFormCustomSelectPref" name="outletp">
              <?php 
                $options = read('outlet');
                foreach($options as $option) :
               ?>
                <option value="<?= $option['id'] ?>"><?= $option['nama'] ?></option>
              <?php endforeach; ?>
              </select>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <input type="submit" class="btn btn-primary" name="create" value="Tambah">
        </div>
          </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/jquery/jquery.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../../js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../../vendor/chart.js/Chart.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../../js/demo/chart-area-demo.js"></script>
  <script src="../../js/demo/chart-pie-demo.js"></script>
  <script type="text/javascript" src="../../datepicker/js/bootstrap-datepicker.min.js"></script>
  
  <script type="text/javascript">
   $(function(){
    $(".datepicker").datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });
   });
  </script>

</body>

</html>