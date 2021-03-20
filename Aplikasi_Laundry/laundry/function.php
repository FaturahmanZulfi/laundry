<?php 
	function read($tbl,$fld='*',$knd =''){
		global $koneksi;
		$field = (is_array($fld)) ? implode(",", $fld) : $fld;

		$sql = "SELECT $fld FROM $tbl $knd";
		$execute = mysqli_query($koneksi,$sql);
		return $execute;
	}
	function create($tbl,$fld,$val){
		global $koneksi;
		$field = (is_array($fld)) ? implode(",",$fld) : $fld;
		$value = (is_array($val)) ? implode(",",$val) : $val;
		$sql = "INSERT INTO $tbl ($field) VALUES($value)";
		$execute = mysqli_query($koneksi,$sql);
		return $execute;
	}
	function update($tbl,$fld,$knd){
		global $koneksi;
		$sql = "UPDATE $tbl SET $fld $knd";
		$execute = mysqli_query($koneksi,$sql);
		return $execute;
	}
	function delete($tbl,$knd){
		global $koneksi;
		$sql = "DELETE FROM $tbl $knd";
		$execute = mysqli_query($koneksi,$sql);
		return $execute;
	}
 ?>