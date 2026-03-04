<?php
session_start();
include "../koneksi.php";

if(!isset($_SESSION['admin'])) {
    header("location: ../admin/login.php");
    exit;
}

if(isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['ket_kategori']);
    mysqli_query($conn, "INSERT INTO kategori (ket_kategori) VALUES ('$nama')");
}

header("location:../admin/kategori.php");
exit;
?>