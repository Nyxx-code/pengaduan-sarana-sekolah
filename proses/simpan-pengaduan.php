<?php
session_start();

include "../koneksi.php";

if(!isset($_SESSION['siswa'])) {
    header ("location: ../siswa/login-siswa.php");
}
?>