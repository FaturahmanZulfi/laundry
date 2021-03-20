<?php 
	require('../koneksi.php');
	include('../function.php');

	$transaksi = 'transaksi';
	$id_transaksi = $_GET['id_transaksi'];
	$kndt = "WHERE id = $id_transaksi";

	$detail_transaksi = 'detail_transaksi';
	$id_detail_transaksi = $_GET['id_detail_transaksi'];
	$knddt = "WHERE id = $id_detail_transaksi";

	$del = delete($detail_transaksi,$knddt);
	if($del){
		$del2 = delete($transaksi,$kndt);
		if($del2){
			header('Location:entri_transaksi.php');
		}
	}
 ?>