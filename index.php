<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fontawesome/css/all.min.css">
    <title>Pengaduan Sarana Sekolah</title>
    <style>
        body {
            background-color : #ffffff
        }

        .hero {
            min-height: 100vh;
            display : flex;
            align-items: center;
        }

        .icon-box {
            font-size: 50px; 
            color: #14abf6; 
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
       
    <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">
                <i class="fa-solid fa-school"></i> Pengaduan Sarana Sekolah 
            </a>
        </div>
    </nav>
    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4">
                    <h1 class="fw-bold">Pengaduan Sarana Sekolah</h1>
                        <p class="text-muted mt-3">
                        Fungsi aplikasi ini adalah sebagai media untuk melaporkan, mencatat, dan menindaklanjuti masalah fasilitas sekolah.
                        </p>
                <div class="mt-4">
                    <a href="siswa/login-siswa.php" class="btn btn-success btn-lg me-2">
                        <i class="fa-solid fa-graduation-cap"></i> Login siswa</a>
                    <a href="admin/login.php" class="btn btn-outline-dark btn-lg">
                        <i class="fa-solid fa-user"></i> Login admin</a>
                </div>
                </div>
        
            
                <div class="col-md-6 text-center">
                <div class="icon-box mb-3">
                    <i class="fa-solid fa-comments"></i>
                </div>
                        <h5 class="fw-semibold">
                                Pengaduan | Umpan balik | Progres
                        </h5>
                <p class="text-muted">
                    Setiap laporan akan ditindaklanjuti oleh pihak sekolah.
                    <br>
                    <b>Dibuat oleh Aulia Usna</b>
                </p>    
            </div>
        </div>

    </section> 
    <footer class="bg-light py-3 text-center"> 
        <small class="text-muted"></small>
        &copy; <?php echo date('Y'); ?>
        Pengaduan Sarana Sekolah UKK RPL
    </footer>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>