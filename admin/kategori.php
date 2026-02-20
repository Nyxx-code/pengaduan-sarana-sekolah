<?php
    //mengaktifkan session
    session_start();

    //mengambil file koneksi yg berisi $conn agar terhubung ke database
    include "../koneksi.php";

    //proteksi halaman admin
    if(!isset($_SESSION['admin'])) {
        header("location: login.php");
        exit;
    }

    //mengambil data kategori dari database
    $data = mysqli_query($conn, "
        SELECT * FROM kategori
        ORDER By id_kategori DESC
    ")

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <title>Data kategori | admin</title>
</head>
<body class="bg-light">
    <!-- navbar -->
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">

            <!-- judul halaman -->
            <a href="index-admin.php" class="navbar-brand">
                <i class="fa-solid fa-tags"></i> Data Kategori
            </a>
                
            <!-- tombol kembali -->
            <div class="d-flex">
                <a href="index-admin.php" class="btn btn-light btn-sm me-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>

                <!-- tombol logout -->
                <a href="../proses/logout.php" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>

            </div>
            
        </div>
    </nav>

    <!-- konten -->
    <div class="container mt-4">
        <div class="card shadow-sm">

            <!-- card header -->
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="fa-solid fa-list"></i> Kategori Sarana
                </h5>
            </div>

            <div class="card-body">
                <form method="post" action="../proses/tambah-kategori.php" class="mb-3">
                    <div class="col-md-8">
                        <input type="text" 
                            name="ket_kategori" 
                            class="form-control" 
                            placeholder="nama kategori" require>
                            <br>

                        <!-- tombol tambah -->
                        <div class="col-md-4 d-grid">
                            <button class="btn btn-success" name="simpan">
                                <i class="fa-solid fa-plus"></i> Tambah
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>