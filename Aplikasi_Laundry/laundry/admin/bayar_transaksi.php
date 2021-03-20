<?php 
	require('../koneksi.php');
	include('../function.php');

	$id_transaksi = $_GET['id_transaksi'];
	$table = 'transaksi';
	$field = "dibayar = 'dibayar',tgl_bayar = CURRENT_TIMESTAMP";
	$kondisi = "WHERE id = $id_transaksi";

	$execute = update($table,$field,$kondisi);
	if($execute) {
		header('Location:entri_transaksi.php');
	}
 ?>