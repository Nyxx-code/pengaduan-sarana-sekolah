<?php
session_start();

include "../koneksi.php";

//cek apakah admin sdh login
if (!isset($_SESSION['admin'])) {
    header("location : login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <title>Dashboard admin</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
       
        <div class="container-fluid">
            <span class="navbar-brand fw-bold" href="#">
                <i class="fa-solid fa-school"></i> Pengaduan Sarana Sekolah - Admin
            </span>
            <div class="d-flex">
                <span class="text-white me-3">
                    <i class="fa-solid fa-user"></i>
                    <?= $_SESSION['admin']; ?>
                </span>
                <a href="../proses/logout.php" class="btn btn-light btn-sm">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 mb-4">
                <div class="alert alert-success">
                    <strong>Selamat datang!</strong>
                    Anda login sebagai <b>admin</b>.
                    Silakan kelola data pengaduan sarana sekolah.
                </div>
            </div>
            <!-- =====================Card 1 ============================= -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-comment text-primary mb-3"></i>
                        <h5>Data Pengaduan</h5>
                        <p class="text-muted">Lihat & kelola pengaduan siswa</p>
                        <a href="data-pengaduan.php" class="btn btn-primary"> Kelola</a>
                    </div>
                </div>
            </div>

                  <!-- =====================Card 2 ============================= -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-list text-primary mb-3"></i>
                        <h5>Kategori</h5>
                        <p class="text-muted">Kelola kategori</p>
                        <a href="data-pengaduan.php" class="btn btn-primary"> Kelola</a>
                    </div>
                </div>
            </div>

            <!-- =====================Card 3 ============================= -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center">
                       <i class="fa-solid fa-user-graduate text-primary mb-3"></i>
                        <h5>Tambah akun siswa</h5>
                        <p class="text-muted">Kelola akun siswa</p>
                        <a href="data-pengaduan.php" class="btn btn-primary"> Tambah siswa</a>
                    </div>
                </div>
            </div>
             

            <!-- =====================Card 4 ============================= -->
            <div class="col-md-4">
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-building-columns text-primary mb-3"></i>
                        <h5>Laporan</h5>
                        <p class="text-muted">Rekap pengaduan siswa</p>
                        <a href="data-pengaduan.php" class="btn btn-primary"> Lihat</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>