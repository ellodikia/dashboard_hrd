<?php
// Pastikan koneksi dan CRUD di-include sebelum HTML
include 'koneksi.php';
include 'crud.php'; 
// Di sini variabel $data sudah tersedia karena blok if(isset($_GET['id']))
// di crud.php dieksekusi saat edit.php diakses.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Karyawan</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h2 { text-align: center; color: #333; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input[type="text"], input[type="email"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* Agar padding tidak melebarkan elemen */
        }
        textarea { resize: vertical; height: 100px; }
        button[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        button[type="submit"]:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Data Karyawan</h2>
        <form method="post" action="crud.php?id=<?= $id ?? ''; ?>">
            <label for="">Nama Lengkap</label>
            <input type="text" name="nama" value="<?= $data['nama'] ?? ''; ?>" required>
            
            <label for="">Jabatan</label>
            <input type="text" name="jabatan" value="<?= $data['jabatan'] ?? ''; ?>" required>
            
            <label for="">Departemen</label>
            <input type="text" name="departemen" value="<?= $data['departemen'] ?? ''; ?>">
            
            <label for="">Email</label>
            <input type="email" name="email" value="<?= $data['email'] ?? ''; ?>">
            
            <label for="">No Telepon</label>
            <input type="text" name="no_telp" value="<?= $data['no_telp'] ?? ''; ?>">
            
            <label for="">Alamat</label>
            <textarea name="alamat"><?= $data['alamat'] ?? ''; ?></textarea>
            
            <button type="submit" name="update">Update Data</button>
        </form>
    </div>
</body>
</html>