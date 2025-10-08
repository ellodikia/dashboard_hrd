<?php
include 'koneksi.php';

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama_lengkap'];
    $nip = $_POST['nip'];
    $jabatan = $_POST['jabatan'];
    $departemen = $_POST['departemen'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $status_karyawan = $_POST['status_karyawan'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $target_file = "";

    // === Upload Foto ===
    if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
        $target_dir = "uploads/";

        if (!is_dir($target_dir)) {
            if (!mkdir($target_dir, 0777, true)) {
                $error = "Gagal membuat folder 'uploads/'. Periksa izin server.";
            }
        }

        if (empty($error)) {
            $foto_name = basename($_FILES["foto"]["name"]);
            $unique_name = time() . "_" . preg_replace("/[^a-zA-Z0-9\._-]/", "_", $foto_name);
            $target_file_temp = $target_dir . $unique_name;
            $imageFileType = strtolower(pathinfo($target_file_temp, PATHINFO_EXTENSION));

            $check = getimagesize($_FILES["foto"]["tmp_name"]);
            if ($check === false) {
                $error = "File yang diunggah bukan gambar!";
            } elseif ($_FILES["foto"]["size"] > 2000000) {
                $error = "Ukuran file terlalu besar (maks 2MB)";
            } elseif (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
                $error = "Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan";
            } else {
                if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file_temp)) {
                    $target_file = $target_file_temp;
                } else {
                    $error = "Gagal mengupload foto. Pastikan folder 'uploads/' memiliki izin tulis.";
                }
            }
        }
    }

    // === Cek dan Simpan ke Database ===
    if (empty($error)) {
        $cek = $koneksi->prepare("SELECT id_karyawan FROM karyawan WHERE nama_lengkap=? OR nip=?");
        $cek->bind_param("ss", $nama, $nip);
        $cek->execute();
        $result = $cek->get_result();

        if ($result->num_rows > 0) {
            // Data sudah ada → hapus foto baru jika ada
            if (!empty($target_file) && file_exists($target_file)) {
                unlink($target_file);
            }
            $error = "Nama karyawan atau NIP sudah terdaftar.";
        } else {
            // Data belum ada → masukkan ke DB
            $stmt = $koneksi->prepare("INSERT INTO karyawan (nama_lengkap, nip, jabatan, departemen, tanggal_masuk, status_karyawan, email, no_hp, alamat, foto) VALUES (?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssssss", $nama, $nip, $jabatan, $departemen, $tanggal_masuk, $status_karyawan, $email, $no_hp, $alamat, $target_file);

            if ($stmt->execute()) {
                $success = "Karyawan <strong>" . htmlspecialchars($nama) . "</strong> berhasil ditambahkan. <a href='index.php'>Kembali ke Dashboard</a>.";
            } else {
                $error = "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
            }
            $stmt->close();
        }
        $cek->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Karyawan</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f7f9;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
            font-weight: 500;
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
        }
        .form-group label {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
            font-weight: 500;
        }
        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="file"],
        select,
        textarea {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 15px;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input[type="file"] {
            padding-top: 8px;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="date"]:focus,
        select:focus,
        textarea:focus {
            border-color: #3498db;
            outline: none;
        }
        .full-width {
            grid-column: 1 / -1;
        }
        /* Style baru untuk Tombol Aksi */
        .form-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            gap: 15px; /* Jarak antar tombol */
            margin-top: 10px;
        }
        .submit-button {
            background-color: #3498db;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        .submit-button:hover {
            background-color: #2980b9;
        }
        .back-button {
            background-color: #7f8c8d;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s ease;
            display: flex; /* Untuk memastikan padding vertikal sama */
            align-items: center;
        }
        .back-button:hover {
            background-color: #636e72;
        }
        .message-box {
            margin-top: 20px;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-weight: 500;
        }
        .success {
            background-color: #e6ffe6;
            color: #008000;
            border: 1px solid #008000;
        }
        .error {
            background-color: #ffe6e6;
            color: #cc0000;
            border: 1px solid #cc0000;
        }
        @media (max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .form-actions {
                flex-direction: column; /* Tumpuk tombol di mobile */
            }
            .submit-button, .back-button {
                width: 100%;
                box-sizing: border-box;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Data Karyawan Baru</h2>

        <?php if (!empty($success)): ?>
            <div class="message-box success"><?= $success ?></div>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <div class="message-box error"><?= $error ?></div>
        <?php endif; ?>

        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= htmlspecialchars($_POST['nama_lengkap'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" name="nip" id="nip" value="<?= htmlspecialchars($_POST['nip'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="jabatan">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" value="<?= htmlspecialchars($_POST['jabatan'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="departemen">Departemen</label>
                    <input type="text" name="departemen" id="departemen" value="<?= htmlspecialchars($_POST['departemen'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" id="tanggal_masuk" value="<?= htmlspecialchars($_POST['tanggal_masuk'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="status_karyawan">Status Karyawan</label>
                    <select name="status_karyawan" id="status_karyawan" required>
                        <option value="" disabled selected>Pilih Status</option>
                        <option value="Tetap" <?= (($_POST['status_karyawan'] ?? '') == 'Tetap') ? 'selected' : '' ?>>Tetap</option>
                        <option value="Kontrak" <?= (($_POST['status_karyawan'] ?? '') == 'Kontrak') ? 'selected' : '' ?>>Kontrak</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="no_hp">No Telepon</label>
                    <input type="text" name="no_hp" id="no_hp" value="<?= htmlspecialchars($_POST['no_hp'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="foto">Foto (maks 2MB, JPG/PNG/GIF)</label>
                    <input type="file" name="foto" id="foto" accept="image/*">
                    <small style="color:#777; margin-top: 5px;">*Foto diperlukan untuk profil.</small>
                </div>
                <div class="form-group full-width">
                    <label for="alamat">Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" rows="3" required><?= htmlspecialchars($_POST['alamat'] ?? '') ?></textarea>
                </div>
                <div class="form-actions full-width">
                    <input type="submit" value="Simpan Data Karyawan" class="submit-button">
                    <a href="index.php" class="back-button">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>