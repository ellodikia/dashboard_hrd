<?php
include 'koneksi.php';
$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM karyawan WHERE id_karyawan=$id");

header("Location: dashboard_hrd.php");
exit;
?>
