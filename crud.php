<?php
include 'koneksi.php';

// =============== //
// == Edit Data == //
// =============== //
if (isset($_GET['id'])) {
    // Amankan ID
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    
    // Query untuk mengambil data yang akan diedit
    $result_edit = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan='$id'");
    $data = mysqli_fetch_assoc($result_edit); // Variabel $data sekarang tersedia

    if (!$data) {
        header("Location: dashboard_hrd.php?error=data_not_found");
        exit;
    }

    // Blok kode untuk pemrosesan UPDATE setelah form disubmit (dari form edit.php)
    if(isset($_POST['update'])) {
        // Ambil data dari form dan amankan
        $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
        $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
        $departemen = mysqli_real_escape_string($koneksi, $_POST['departemen']);
        $email = mysqli_real_escape_string($koneksi, $_POST['email']);
        $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
        $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

        // Jalankan query UPDATE
        mysqli_query($koneksi, "UPDATE karyawan SET
        nama='$nama',
        jabatan='$jabatan',
        departemen='$departemen',
        email='$email',
        no_telp='$no_telp',
        alamat='$alamat'
        WHERE id_karyawan='$id'");

        header("Location: dashboard_hrd.php?status=sukses_update");
        exit;
    }
} 

// =============== //
// = Tambah Data = //
// =============== //
if(isset($_POST['simpan'])){
    // Ambil data dari form dan amankan
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($koneksi, $_POST['jabatan']);
    $departemen = mysqli_real_escape_string($koneksi, $_POST['departemen']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $no_telp = mysqli_real_escape_string($koneksi, $_POST['no_telp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    $query = "INSERT INTO karyawan (nama, jabatan, departemen, email, no_telp, alamat)
    VALUES ('$nama', '$jabatan', '$departemen', '$email', '$no_telp', '$alamat')";

    mysqli_query($koneksi, $query);
    header ("Location: dashboard_hrd.php");
    exit();
}

?>