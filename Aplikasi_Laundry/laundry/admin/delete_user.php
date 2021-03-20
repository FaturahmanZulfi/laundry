<?php 
	require('../koneksi.php');
	include('../function.php');

	$id = $_GET['id'];
	$table = 'user';
	$kondisi = "WHERE id = $id";

	$del = delete($table,$kondisi);
	if($del) {
		header('Location:user.php');
	}else{
		header('Location:user.php');
	}
 ?>