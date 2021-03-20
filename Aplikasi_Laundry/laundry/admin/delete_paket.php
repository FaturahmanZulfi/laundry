<?php 
	require('../koneksi.php');
	include('../function.php');

	$id = $_GET['id'];
	$table = 'paket';
	$kondisi = "WHERE id = $id";

	$del = delete($table,$kondisi);
	if($del) {
		header('Location:paket.php');
	}else{
		header('Location:paket.php');
	}
 ?>