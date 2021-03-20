<?php 
  require('../koneksi.php');
  include('../function.php');
  session_start();
  if(!($_SESSION['role'] === 'owner')){
    header("Location:../../");
  }else{
    $nama = $_SESSION['nama'];
    $role = $_SESSION['role'];
    $id_user = $_SESSION['id'];
  }

  if(ISSET($_POST['logout'])){
    session_destroy();
    header('Location:../../');
  }

  $sql = "SELECT transaksi.id as id_transaksi,detail_transaksi.id as id_detail_transaksi,member.nama as member,paket.jenis,paket.nama_paket,detail_transaksi.qty,outlet.nama as outlet,transaksi.tgl,transaksi.batas_waktu,transaksi.tgl_bayar,transaksi.biaya_tambahan,transaksi.diskon,transaksi.pajak,transaksi .dibayar,user.nama as nama_user,detail_transaksi.total_bayar,detail_transaksi.keterangan FROM transaksi INNER JOIN member ON transaksi.id_member = member.id INNER JOIN detail_transaksi ON detail_transaksi.id_transaksi = transaksi.id INNER JOIN paket ON detail_transaksi.id_paket = paket.id INNER JOIN outlet ON transaksi.id_outlet = outlet.id INNER JOIN user ON transaksi.id_user = user.id WHERE transaksi.dibayar = 'dibayar' ORDER BY transaksi.id ASC";
  $records = mysqli_query($koneksi,$sql);

  $no = mysqli_query($koneksi, "SELECT kode_invoice FROM transaksi ORDER BY kode_invoice DESC");
  $invoice = mysqli_fetch_array($no);
  $bln = date("m");
  $thn = date("y");

  if ($invoice === NULL) {
    $invoice = "LD".$bln.$thn."001";
  }else{
    $kode = $invoice['kode_invoice'];
    $urut =  substr($kode, 6, 3);
    $tambah = (int) $urut + 1;

    if(strlen($tambah) == 1){
      $invoice = "LD".$bln.$thn."00".$tambah;
    }else if(strlen($tambah) == 2){
      $invoice = "LD".$bln.$thn."0".$tambah;
    }else{
      $invoice = "LD".$bln.$thn.$tambah;
    }
  }

  if (ISSET($_POST['create'])) {
    $table = 'transaksi';
    $table2 = 'detail_transaksi';
    $id_outlet = $_POST['outlet'];
    $id_member = $_POST['member'];
    $batas_waktu = $_POST['batas_waktu'];
    $biaya_tambahan = $_POST['bita'];
    $id_paket = $_POST['paket'];
    $qty = $_POST['qty'];
    $keterangan = $_POST['keterangan'];

    $fieldhp = "harga";
    $kndhp = "WHERE id = $id_paket";
    $exehp = read('paket',$fieldhp,$kndhp);
    $resid = mysqli_fetch_array($exehp);
    $hargaPaket = $resid['harga'];
    $total_bayar = ((int) $hargaPaket * $qty) + (int) $biaya_tambahan;

    $fieldid = "MAX(id)";
    $exeid = read($table,$fieldid);
    $resid = mysqli_fetch_array($exeid);
    if ($resid['MAX(id)'] === null) {
      $id_transaksi = 1;
    }else{
      $id_transaksi = $resid['MAX(id)']+1;
    }

    $field = ['id','id_outlet','kode_invoice','id_member','tgl','batas_waktu','tgl_bayar','biaya_tambahan','diskon','pajak','dibayar','id_user'];
    $values = ["'$id_transaksi'","'$id_outlet'","'$invoice'","'$id_member'",'CURRENT_TIMESTAMP',"'$batas_waktu'","NULL","'$biaya_tambahan'",'0','0',"'belum_dibayar'","'$id_user'"];

    $create = create($table,$field,$values);
    if ($create) {
      $field = ['id_transaksi','id_paket','qty','total_bayar','keterangan'];
      $values = ["'$id_transaksi'","'$id_paket'","'$qty'","'$total_bayar'","'$keterangan'"];
      $create2 = create($table2,$field,$values);
      if ($create2) {
        header('Location:entri_transaksi.php');
      }
    }else{
      echo mysqli_error($koneksi);
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
      <li class="nav-item active">
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
          
          <h1>Laporan</h1>

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
                  <h6 class="m-0 font-weight-bold text-primary">Laporan</h6>
                </div>
                <div class="card-body">

                  <a href="generate.php" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-100">
                      <i class="fa fa-file-excel-o"></i>
                    </span>
                    <span class="text">Generate Laporan Ke Excel</span>
                  </a>

                  <table class="table mt-3">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Member</th>
                        <th scope="col">Nama Paket</th>
                        <th scope="col">outlet</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; foreach($records as $record) : ?>
                        <tr>
                          <th scope="row"><?= $no ?></th>
                          <td><?= $record['member'] ?></td>
                          <td><?= $record['nama_paket'] ?></td>
                          <td><?= $record['outlet'] ?></td>
                          <td>
                            <button class="btn btn-success btn-icon-split lihat_detail"
                              data-namam = "<?= $record['member'] ?>"
                              data-namap = "<?= $record['nama_paket'] ?>"
                              data-jenpak = "<?= $record['jenis'] ?>"
                              data-qty = "<?= $record['qty'] ?>"
                              data-outlet = "<?= $record['outlet'] ?>"
                              data-tgl = "<?= $record['tgl'] ?>"
                              data-bataswaktu = "<?= $record['batas_waktu'] ?>"
                              data-bita = "<?= $record['biaya_tambahan'] ?>"
                              data-diskon = "<?= $record['diskon'] ?>"
                              data-pajak = "<?= $record['pajak'] ?>"
                              data-stayar = "<?= $record['dibayar'] ?>"
                              data-user = "<?= $record['nama_user'] ?>"
                              data-toba = "<?= $record['total_bayar'] ?>"
                              data-tgl_bayar = "<?= $record['tgl_bayar'] ?>"
                            >
                              <span class="icon text-white-100">
                                Detail
                              </span>
                            </button>
                            <!-- <a href="delete_transaksi.php?id_transaksi=<?= $record['id_transaksi'] ?>&id_detail_transaksi=<?= $record['id_detail_transaksi'] ?>" onclick="return confirm('anda yakin ingin menghapus data ini ?')" class="btn btn-danger btn-icon-split">
                              <span class="icon text-white-100">
                                <i class="fa fa-minus"></i>
                              </span>
                            </a> -->
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

  <!-- Detail Modal-->
  <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Detail Data Transaksi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST">
        <div class="modal-body">

          <div class="form-group row">
            <label for="namam" class="col-sm-2 col-form-label">Nama Member</label>
            <div class="col-sm-10">
              <input type="text" name="namam" class="form-control" id="namam" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="namap" class="col-sm-2 col-form-label">Nama Paket</label>
            <div class="col-sm-10">
              <input type="text" name="namap" class="form-control" id="namap" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="jenpak" class="col-sm-2 col-form-label">Jenis Paket</label>
            <div class="col-sm-10">
              <input type="text" name="jenpak" class="form-control" id="jenpak" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="Outlet" class="col-sm-2 col-form-label">Nama Outlet</label>
            <div class="col-sm-10">
              <input type="text" name="Outlet" class="form-control" id="outlet" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="qty" class="col-sm-2 col-form-label">Qty</label>
            <div class="col-sm-10">
              <input type="text" name="qty" class="form-control" id="qty" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="tgl" class="col-sm-2 col-form-label">Tanggal Transaksi</label>
            <div class="col-sm-10">
              <input type="text" name="tgl" class="form-control" id="tgl" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="bawa" class="col-sm-2 col-form-label">Batas Waktu</label>
            <div class="col-sm-10">
              <input type="text" name="bawa" class="form-control" id="bataswaktu" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="tgl_bayar" class="col-sm-2 col-form-label">Tanggal Bayar</label>
            <div class="col-sm-10">
              <input type="text" name="tgl_bayar" class="form-control" id="tgl_bayar" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="bita" class="col-sm-2 col-form-label">Biaya Tambahan</label>
            <div class="col-sm-10">
              <input type="text" name="bita" class="form-control" id="bita" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="Stayar" class="col-sm-2 col-form-label">Status Pembayaran</label>
            <div class="col-sm-10">
              <input type="text" name="Stayar" class="form-control" id="stayar" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="user" class="col-sm-2 col-form-label">Nama User</label>
            <div class="col-sm-10">
              <input type="text" name="user" class="form-control" id="user" disabled>
            </div>
          </div>
          <div class="form-group row">
            <label for="toba" class="col-sm-2 col-form-label">Total Bayar</label>
            <div class="col-sm-10">
              <input type="text" name="toba" class="form-control" id="toba" disabled>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Kembali</button>
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
    $('.lihat_detail').click(function(){
      $('#detail').modal();
      var namam   = $(this).attr('data-namam')
      var namap = $(this).attr('data-namap')
      var jenpak   = $(this).attr('data-jenpak')
      var qty   = $(this).attr('data-qty')
      var outlet   = $(this).attr('data-outlet')
      var tgl   = $(this).attr('data-tgl')
      var bataswaktu   = $(this).attr('data-bataswaktu')
      var bita   = $(this).attr('data-bita')
      var user   = $(this).attr('data-user')
      var toba   = $(this).attr('data-toba')
      var stayar   = $(this).attr('data-stayar')
      var keterangan   = $(this).attr('data-keterangan')
      var tgl_bayar   = $(this).attr('data-tgl_bayar')
      $('#namam').val(namam)
      $('#namap').val(namap)
      $('#jenpak').val(jenpak)
      $('#qty').val(qty)
      $('#outlet').val(outlet)
      $('#tgl').val(tgl)
      $('#bataswaktu').val(bataswaktu)
      $('#bita').val(bita)
      $('#user').val(user)
      $('#toba').val(toba)
      $('#stayar').val(stayar)
      $('#keterangan').val(keterangan)
      $('#tgl_bayar').val(tgl_bayar)
    })
    $(function() {
      $('#only-number').on('keydown', '#number', function(e){
          -1!==$
          .inArray(e.keyCode,[46,8,9,27,13,110,190]) || /65|67|86|88/
          .test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey)
          || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey|| 48 > e.keyCode || 57 < e.keyCode)
          && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
        });
    })
    $(function() {
      $('#only-number2').on('keydown', '#number2', function(e){
          -1!==$
          .inArray(e.keyCode,[46,8,9,27,13,110,190]) || /65|67|86|88/
          .test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey)
          || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey|| 48 > e.keyCode || 57 < e.keyCode)
          && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
        });
    })
    $(function() {
      $('#only-number3').on('keydown', '#number3', function(e){
          -1!==$
          .inArray(e.keyCode,[46,8,9,27,13,110,190]) || /65|67|86|88/
          .test(e.keyCode) && (!0 === e.ctrlKey || !0 === e.metaKey)
          || 35 <= e.keyCode && 40 >= e.keyCode || (e.shiftKey|| 48 > e.keyCode || 57 < e.keyCode)
          && (96 > e.keyCode || 105 < e.keyCode) && e.preventDefault()
        });
    })
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