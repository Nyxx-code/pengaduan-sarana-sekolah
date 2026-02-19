<?php

    session_start();

    include "../koneksi.php";

    //proteksi admin
    if(!isset($_SESSION['admin'])) {
        header("location: ../admin/login.php");
        exit;
    } 

    if(!isset($_GET['id'])) {
        header("location: ../admin/data-pengaduan.php");
        exit;
    }

    $id_pelaporan = mysqli_real_escape_string($conn, $_GET['id']);

    //ambil id_kategori
    $q = mysqli_query($conn, "
        SELECT id_kategori
        FROM input_aspirasi
        WHERE id_pelaporan = '$id_pelaporan'
    ");

    $data = mysqli_fetch_assoc($q);

    //hapus di tabel aspirasi (jika ada)
    if($data) {
        mysqli_query($conn, "
        DELETE FROM aspirasi
        WHERE id_aspirasi = '{$data['id_aspirasi']}'
        ");
    }

    //hapus laporan
    mysqli_query($conn, "
        DELETE FROM input_aspirasi
        WHERE id_pelaporan = '$id_pelaporan'
        ");

    header("location: ../admin/data-pengaduan.php");
    exit;
?>