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

    // mengambil id kategori dari form yg dipilih siswa
    $id_kategori = mysqli_real_escape_string($conn, $_POST['id_kategori']);

    //mengambil data lokasi dari form lokasi
    $lokasi = mysqli_real_escape_string($conn, $_POST['lokasi']);

     //mengambil data deskripsi dari form deskripsi
    $ket = mysqli_real_escape_string($conn, $_POST['ket']);

    mysqli_query($conn, 
    "INSERT INTO input_aspirasi (nis, id_kategori, lokasi, ket)
    VALUES ('$nis', '$id_kategori', '$lokasi', '$ket')");

    header("location: ../siswa/index-siswa.php");
    exit;
?>