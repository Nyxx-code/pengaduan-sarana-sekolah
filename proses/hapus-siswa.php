<?php
    session_start();
    include "../koneksi.php";

    if(!isset($_SESSION['admin'])){
        header("location: ../admin/login.php");
        exit;
    }

    if(isset($_GET['nis'])){

        $nis = $_GET['nis'];

        mysqli_query($conn, "DELETE FROM siswa WHERE nis='$nis'");

        $_SESSION['success'] = "Data siswa berhasil dihapus!";
        header("location: ../admin/tambah-siswa.php");
    }
?>