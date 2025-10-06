<?php

// index.php

include 'koneksi.php';

$query = "SELECT * FROM karyawan ORDER BY id_karyawan ASC";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($koneksi));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan Responsif</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="container">
        <h2>Data Karyawan</h2>

        <div class="header-actions">
            <a href='tambah.php' class='add-button'>➕ Tambah Karyawan</a>
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
                    <th class="action-links">Aksi</th> 
                </tr>
            </thead>
            <tbody> 
                <?php
                if (mysqli_num_rows($result) > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                        $foto_path = empty($row['foto']) ? 'placeholder/default_4x4.jpg' : htmlspecialchars($row['foto']);

                        // Simpan label header di array untuk digunakan di mobile
                        $data_labels = [
                            'ID', 'Nama Lengkap', 'NIP', 'Jabatan', 'Departemen',
                            'No Telepon', 'Email', 'Alamat', 'Tgl. Masuk', 'Status', 'Foto', 'Aksi'
                        ];
                        
                        // Array data karyawan
                        $data_values = [
                            htmlspecialchars($row['id_karyawan']),
                            htmlspecialchars($row['nama_lengkap']),
                            htmlspecialchars($row['nip']),
                            htmlspecialchars($row['jabatan']),
                            htmlspecialchars($row['departemen']),
                            htmlspecialchars($row['no_hp']),
                            htmlspecialchars($row['email']),
                            htmlspecialchars($row['alamat']),
                            htmlspecialchars($row['tanggal_masuk']),
                            htmlspecialchars($row['status_karyawan']),
                            "<img src='" . $foto_path . "' alt='Foto Karyawan'>",
                            // Kolom Aksi harus di-handle secara terpisah di bawah
                        ];

                        echo "<tr>";
                        
                        // Cetak semua kolom data dengan atribut data-label
                        for ($i = 0; $i < count($data_values) - 1; $i++) {
                            echo "<td data-label='" . $data_labels[$i] . "'>" . $data_values[$i] . "</td>";
                        }
                        
                        // Kolom Aksi (Handle terpisah)
                        echo "<td class='action-links' data-label='Aksi'>";
                        echo "<a href='edit.php?id=" . htmlspecialchars($row['id_karyawan']) . "' class='action-link edit'>Edit</a>"; 
                        echo "<a href='hapus.php?id=" . htmlspecialchars($row['id_karyawan']) . "' class='action-link delete' onclick=\"return confirm('Yakin hapus data ini?');\">Hapus</a>";
                        echo "</td>";
                        
                        echo "</tr>"; 
                    }
                } else {
                    echo "<tr><td colspan='12' class='no-data'>Tidak ada data karyawan.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>