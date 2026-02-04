<?php
session_start();

include "../koneksi.php";

if (!isset($_POST['login'])) {
    header("location: ../siswa/login-siswa.php");
}

//mengecek apakah NIS ada di tabel siswa
$nis = mysqli_real_escape_string($conn, $_POST['nis']);

$query = mysqli_query(
    $conn,
    "SELECT * FROM siswa WHERE nis = '$nis'"
);

// mengecek jumlah data yg di temukan di tabel siswa
if (mysqli_num_rows($query) == 1) {
    $data = mysqli_fetch_assoc($query);

    // menyimpan nis siswa ke session
    $_SESSION['siswa'] = [
        'nis' => $data ['nis'],
        'nama' => $data['nama'],
        'kelas' => $data['kelas']
    ];
    // jika data login siswa benar dan ada di database  maka akan masuk ke halaman siswa
    header ("location: ../siswa/index-siswa.php");
    exit;

    // jika nis salah  dan  tdk ada di database
} else {

// maka tampilkan pemberitahuan dn berpindah ke login siswa
    echo "<script> alert('Nis tidak terdaftar')
    window.location='../siswa/login-siswa.php';
    </script>";
}
?>