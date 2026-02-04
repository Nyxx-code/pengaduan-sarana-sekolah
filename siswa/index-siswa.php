<?php
session_start();

//mengamankan login siswa
if (!isset($_SESSION['siswa'])){
    header("location: ../login-siswa.php");
exit;
}

$siswa = $_SESSION['siswa'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <title>Dashboard siswa</title>
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-success">
        <div class="container-fluid">
            <span class="navbar-brand">
                <i class="fa-solid fa-graduation-cap"></i> Pengaduan Sarana Sekolah - siswa
            </span>
            <a href="../proses/logout-siswa.php" class="btn btn-sm btn-light">
                <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
            </a>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5>Anda login dengan NIS: <?= $siswa['nis']; ?></h5>
                <p>Kelas : <b><?= $siswa['kelas']; ?></b></p>
                <hr>

                <a href="input-pengaduan.php" class="btn btn-success">
                    <i class="fa-solid fa-plus"></i> Buat pengaduan
                </a>

                <a href="riwayat-pengaduan.php" class="btn btn-warning">
                    <i class="fa-solid fa-plus"></i> Riwayat pengaduan
                </a>
            </div>
        </div>
    </div>

    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>