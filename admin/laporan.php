<?php
    session_start();

    //cek login admin
    if(!isset($_SESSION['admin'])) {
        header("location: ../admin/login.php");
        exit;
    }

    //query gabungan
    $query = mysqli_query($conn, "
    SELECT
        ia.tanggal,
        s.nis,
        s.kelas,
        k.ket_kategori,
        ia.ket AS pengaduan,
        a.feedback
    FROM input_aspirasi ia
    JOIN siswa s ON ia.nis = s.nis
    JOIN kategori k ON ia.id_kategori = k.id_kategori
    LEFT JOIN aspirasi a ON ia.id_kategori = a.id_kategori
    ORDER BY ia.tanggal DESC
    ")
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <title>Laporan | admin</title>
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
                
                <a href="../proses/logout.php" class="btn btn-light btn-sm">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>
    </nav>
    
</body>
</html>