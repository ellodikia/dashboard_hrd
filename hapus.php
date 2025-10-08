<?php
include 'koneksi.php';

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $query_foto = "SELECT foto FROM karyawan where id_karyawan = $id";
    $result_foto = mysqli_query($koneksi, $query_foto);

    if( $result_foto && mysqli_num_rows($result_foto)>0){
        $data = mysqli_fetch_assoc($result_foto);
        $foto_path = $data['foto'];

    if(!empty($foto_path) && file_exists($foto_path)){
        unlink($foto_path); 
    }
    }

    $query_delete = "DELETE FROM karyawan WHERE id_karyawan =$id";
    $result_delete = mysqli_query($koneksi, $query_delete);

    if($result_delete){
        echo "<script>
            alert('Data karyawan berhasil dihapus!');
            window.location='index.php';
            </script>";
        } else {
        echo "<script>
            alert('Gagal menghapus data: ". mysqli_error($koneksi) . "');
            window.location='index.php';
            </script>";
        }
    } else {
    echo "<script>
        alert('id tidak ditemukan: ". mysqli_error($koneksi) . "');
        window.location='index.php';
        </script>"; 
}
?>