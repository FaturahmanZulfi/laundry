<?php 
	require('../koneksi.php');
	include('../function.php');

	$id = $_GET['id'];
	$table = 'outlet';
	$kondisi = "WHERE id = $id";

	$del = delete($table,$kondisi);
	if($del) {
		header('Location:outlet.php');
	}else{
		header('Location:outlet.php');
	}
 ?>