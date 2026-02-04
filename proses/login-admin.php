<?php
session_start();

include "../koneksi.php";

// Tombol login di tekan
if (!isset($_POST['login'])) {
    header("location: ../admin/login.php");
    exit;
}

//ambil data dari form login.php
$username = mysqli_real_escape_string(
    $conn,
    $_POST['username']
);

$password = md5(
   mysqli_real_escape_string($conn, $_POST['password'])

);

//query cek admin
$query = mysqli_query (
$conn, "SELECT * FROM admin WHERE username='$username' AND password='$password' "
);

// jika ada 1 data yg cocok, maka login akan berhasil 
if (mysqli_num_rows($query) == 1) {

// diarahkan ke halaman admin
$_SESSION['admin'] = $username;
    header("location: ../admin/index-admin.php");
    exit; // prosesnya berhenti
}else {
    //jika login gagal
    echo "<script> alert('username atau password salah');
    window.location='../login.php'; </script>";
    exit;
}

?>