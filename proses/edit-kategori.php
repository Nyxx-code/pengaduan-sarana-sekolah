<?php
    //mengaktifkan session untuk menyimpan data login admin
    session_start();

    //mengambil file koneksi database
    include "../koneksi.php";

    //mengecek admin sudah login atau menekan tombol login
    if(!isset($_SESSION['admin'])) {
        header("location: ../admin/login.php");
        exit;
    }

    //mengecek apakah parameter ID dan nama yang di kirim melalui URL
    if(!isset($_GET['id'])) {
        header("location: ../admin/kategori.php");
        exit;
    }

    //mengambil id dan nama kategori dari URL
    $id = $_GET['id'];
    $nama = $_GET['nama'];

    //mengecek apakah tombol update di tekan
    if(isset($_POST('update'))) {
        $nama_baru = htmlspecialchars($_POST['ket_kategori']);
        
    }
?>