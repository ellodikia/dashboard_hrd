<?php
session_start();
include 'koneksi.php';
include 'crud.php';

if(!isset($_SESSION['username']) || $_SESSION ['level'] != "hrd"){
    header ("Location: login.php");
    exit();
}

// =============== //
// == Lihat Data = //
// =============== //
$result = mysqli_query($koneksi, "SELECT * FROM karyawan"); // Dipindahkan dari crud.php

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard HRD</title>
</head>
<body>
<h1>Dashboard HRD</h1>
<p><a href="logout.php">Keluar</a></p>
<p><a href="tambah.php">Tambah Data</a></p>
<table border="1" cellpadding="8">
  <tr>
    <th>ID</th>
    <th>Nama</th>
    <th>Jabatan</th>
    <th>Departemen</th>
    <th>Email</th>
    <th>No Telp</th>
    <th>Alamat</th>
    <th>Aksi</th>
  </tr>

  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
  <tr>
    <td><?= $row['id_karyawan']; ?></td>
    <td><?= $row['nama']; ?></td>
    <td><?= $row['jabatan']; ?></td>
    <td><?= $row['departemen']; ?></td>
    <td><?= $row['email']; ?></td>
    <td><?= $row['no_telp']; ?></td>
    <td><?= $row['alamat']; ?></td>
    <td>
      <a href="edit.php?id=<?= $row['id_karyawan']; ?>">Edit</a> |
      <a href="hapus.php?id=<?= $row['id_karyawan']; ?>" onclick="return confirm('Yakin?')">Hapus</a>
    </td>
  </tr>
  <?php } ?>
</table>

</body>
</html>