<?php 
  require('../koneksi.php');
  include('../function.php');
  session_start();
  if(!($_SESSION['role'] === 'admin')){
    header("Location:../../");
  }else{
    $nama = $_SESSION['nama'];
    $role = $_SESSION['role'];
    $id_user = $_SESSION['id'];
  }

  $sql = "SELECT transaksi.id as id_transaksi,detail_transaksi.id as id_detail_transaksi,member.nama as member,paket.jenis,paket.nama_paket,detail_transaksi.qty,outlet.nama as outlet,transaksi.tgl,transaksi.batas_waktu,transaksi.tgl_bayar,transaksi.biaya_tambahan,transaksi.diskon,transaksi.pajak,transaksi .dibayar,user.nama as nama_user,detail_transaksi.total_bayar,detail_transaksi.keterangan FROM transaksi INNER JOIN member ON transaksi.id_member = member.id INNER JOIN detail_transaksi ON detail_transaksi.id_transaksi = transaksi.id INNER JOIN paket ON detail_transaksi.id_paket = paket.id INNER JOIN outlet ON transaksi.id_outlet = outlet.id INNER JOIN user ON transaksi.id_user = user.id WHERE transaksi.dibayar = 'dibayar' ORDER BY transaksi.id ASC";
  $records = mysqli_query($koneksi,$sql);
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=laporanLaundry.xls");
 ?>
<!DOCTYPE html>
<html lang="en">

<head>

  <title>Laundry - Dashboard</title>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Content Row -->

          <div class="row">

            <div class="col-lg-12 mb-4">

              <!-- Approach -->
              
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h1 class="m-0 font-weight-bold text-primary">Laporan Laundry</h1>
                </div>
                <div class="card-body">

                  <table class="table mt-3" border="1">
                    <thead>
                      <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Member</th>
                        <th scope="col">Nama User</th>
                        <th scope="col">Nama Paket</th>
                        <th scope="col">Jenis Paket</th>
                        <th scope="col">Outlet</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Biaya Tambahan</th>
                        <th scope="col">Total Biaya</th>
                        <th scope="col">Status Pembayaran</th>
                        <th scope="col">Tanggal Transaksi</th>
                        <th scope="col">Batas Waktu</th>
                        <th scope="col">Tanggal Bayar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; foreach($records as $record) : ?>
                        <tr>
                          <th scope="row"><?= $no ?></th>
                          <td><?= $record['member'] ?></td>
                          <td><?= $record['nama_user'] ?></td>
                          <td><?= $record['nama_paket'] ?></td>
                          <td><?= $record['jenis'] ?></td>
                          <td><?= $record['outlet'] ?></td>
                          <td><?= $record['qty'] ?></td>
                          <td><?= $record['biaya_tambahan'] ?></td>
                          <td><?= $record['total_bayar'] ?></td>
                          <td><?= $record['dibayar'] ?></td>
                          <td><?= $record['tgl'] ?></td>
                          <td><?= $record['batas_waktu'] ?></td>
                          <td><?= $record['tgl_bayar'] ?></td>
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

</body>

</html>