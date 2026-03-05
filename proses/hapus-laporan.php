<?php
session_start();
include "../koneksi.php";

if(!isset($_SESSION['admin'])) {
    header("location: ../admin/login.php");
    exit;
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM input_aspirasi WHERE id_pelaporan='$id'");

header("location: ../admin/laporan.php");
exit;
?>