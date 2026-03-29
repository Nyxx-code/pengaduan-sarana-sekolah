<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['siswa'])) {
    header("location: ../siswa/login-siswa.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM input_aspirasi WHERE id_pelaporan='$id'");

header("location: ../siswa/riwayat-pengaduan.php");
exit;
?>