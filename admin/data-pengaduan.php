<?php
    session_start();

    include ("../koneksi.php");

    if(!isset($_SESSION['admin'])) {
        header("location: login.php");
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
    <title>Data Pengaduan</title>
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

                    <a href="index-admin.php" class="btn btn-danger btn-sm me-2">
                       <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                        <a href="../proses/logout.php" class="btn btn-light btn-sm">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </a>
            </div>

        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white"> 
                <h5 class="mb-0"><i class="fa-solid fa-comment"></i> Data pengaduan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>NIS</th>
                                <th>Kelas</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;

                                $query = mysqli_query($conn, "
                                SELECT 
                                ia. id_pelaporan,
                                ia. tanggal,
                                S. nis,
                                s. kelas,
                                k. ket_kategori,
                                ia. lokasi
                                ia. ket,
                                a. status
                                FROM input_aspirasi ia
                                -- ia = alias tabel input_aspirasi

                                JOIN siswa s ON ia.nis = s.nis
                                --menggabungkan tabel siswa berdasarkan nis

                                JOIN kategori k ON ia.id_kategori = k.id_kategori

                                LEFT JOIN aspirasi a ON ia.id_kategori = a.id_kategori

                                ORDER BY ia.tanggal DESC
                                ");
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</body>
</html>