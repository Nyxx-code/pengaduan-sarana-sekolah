<?php
    session_start();
    include "../koneksi.php";

    if(isset($_POST['update'])){

        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];

        $query = mysqli_query($conn,"UPDATE siswa SET
        nama='$nama',
        kelas='$kelas'
        WHERE nis='$nis'");

        if($query){

        $_SESSION['success'] = "Data siswa berhasil diupdate";

        header("location: ../admin/tambah-siswa.php");
        exit;

        }else{

        echo "Gagal mengupdate data";

        }

    }
?>