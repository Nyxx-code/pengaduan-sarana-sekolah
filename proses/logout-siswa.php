<?php
    session_start();
    unset($_SESSION['siswa']);
    session_destroy();
    header("location: ../siswa/login-siswa.php");
    exit;


?>