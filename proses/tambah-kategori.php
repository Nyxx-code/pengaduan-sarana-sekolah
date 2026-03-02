<?php
    //mengaktifkan session utk menyimpan data login admin
    session_start();

    //memanggil file koneksi database berisi variabel $conn untuk menghubungkan ke database
    include "../koneksi.php";

    //cek apakah admin sdh login, jika session admin tdk ditemukan/tdk ada, maka akan ke login.php
    if(!isset($_SESSION['admin'])) {
        header("location: ../admin/login.php");
        exit;
    }

    //cek apakah tombol simpan pada form kategori ditekan
    if(isset($_POST['admin'])) {
        $nama = mysqli_real_escape_string($conn, $_POST['ket_kategori']);
        mysqli_query($conn, "INSERT INTO kategori (ket_kategori) VALUES ('$nama')");
    }

    //setelah query dijalankan untuk menyimpan data ke database, admin akan diarahkan ke halam kategori
    header("location:../admin/kategori.php");
    exit;
?>