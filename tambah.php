<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Karyawan</title>
</head>
<body>
    <form method="post" action="crud.php">
    <input type="text" name="nama" placeholder="Nama" required>
    <input type="text" name="jabatan" placeholder="Jabatan" required>
    <input type="text" name="departemen" placeholder="Departemen">
    <input type="email" name="email" placeholder="Email">
    <input type="text" name="no_telp" placeholder="No Telepon">
    <textarea name="alamat" placeholder="Alamat"></textarea>
    <input type="submit" value="Simpan" name="simpan">
</form>

</body>
</html>