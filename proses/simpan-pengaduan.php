<?php
    session_start();

    include "../koneksi.php";

    //proteksi login siswa
    if(!isset($_SESSION['siswa'])) {
    header("location: ../siswa/login-siswa.php");
    exit;
    }

    //mengambil nis dari database
    $nis = $_SESSION['siswa']['nis'];

    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);

    $lokasi = mysqli_real_escape($conn, $_POST['lokasi']);

    $ket = mysqli_real_escape($conn, $_POST['ket']);
?>