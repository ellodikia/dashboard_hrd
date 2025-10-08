<?php
// index.php
include 'koneksi.php';

// Ambil semua data karyawan
$query = "SELECT * FROM karyawan ORDER BY id_karyawan ASC";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css"> 
</head>
<body>
    <div class="container">
        <h2>📋 Data Karyawan</h2>

        <div class="header-actions">
            <a href="tambah.php" class="add-button">➕ Tambah Karyawan</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>No Telepon</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Tgl. Masuk</th>
                    <th>Status</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Pastikan path foto benar
                        $foto_path = !empty($row['foto']) && file_exists($row['foto'])
                            ? htmlspecialchars($row['foto'])
                            : 'placeholder/default_4x4.jpg'; // Pastikan placeholder ini ada

                        echo "<tr>";
                        echo "<td data-label='ID'>{$row['id_karyawan']}</td>";
                        echo "<td data-label='Nama Lengkap'>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
                        echo "<td data-label='NIP'>" . htmlspecialchars($row['nip']) . "</td>";
                        echo "<td data-label='Jabatan'>" . htmlspecialchars($row['jabatan']) . "</td>";
                        echo "<td data-label='Departemen'>" . htmlspecialchars($row['departemen']) . "</td>";
                        echo "<td data-label='No Telepon'>" . htmlspecialchars($row['no_hp']) . "</td>";
                        echo "<td data-label='Email'>" . htmlspecialchars($row['email']) . "</td>";
                        echo "<td data-label='Alamat'>" . htmlspecialchars($row['alamat']) . "</td>";
                        echo "<td data-label='Tgl. Masuk'>" . htmlspecialchars($row['tanggal_masuk']) . "</td>";
                        echo "<td data-label='Status'>" . htmlspecialchars($row['status_karyawan']) . "</td>";
                        // Menambahkan class 'photo-cell' yang dibutuhkan oleh index.css
                        echo "<td class='photo-cell' data-label='Foto'><img src='" . $foto_path . "' alt='Foto Karyawan'></td>";

                        echo "<td class='action-links' data-label='Aksi'>
                                <a href='edit.php?id={$row['id_karyawan']}' class='action-link edit'>Edit</a>
                                <a href='hapus.php?id={$row['id_karyawan']}' class='action-link delete' onclick=\"return confirm('Yakin ingin menghapus data ini?');\">Hapus</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='12' class='no-data'>Belum ada data karyawan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>