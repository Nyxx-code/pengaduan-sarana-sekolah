<?php
    //mengaktifkan session untuk menyimpan data login admin
    session_start();

    //mengambil file koneksi database
    include "../koneksi.php";

    //mengecek admin sudah login atau menekan tombol login
    if(!isset($_SESSION['admin'])) {
        header("location: ../admin/login.php");
        exit;
    }

    //mengecek apakah parameter ID dan nama yang di kirim melalui URL
    if(!isset($_GET['id'])) {
        header("location: ../admin/kategori.php");
        exit;
    }

    //mengambil id dan nama kategori dari URL
    $id = $_GET['id'];
    $nama = $_GET['nama'];

    //mengecek apakah tombol update di tekan
    if (isset($_POST['update'])) {
    $nama_baru = htmlspecialchars($_POST['ket_kategori']);
    
    mysqli_query($conn, "UPDATE kategori
                         SET ket_kategori='$nama_baru'
                         WHERE id_kategori='$id'");

    //menampilkan notifikasi berhasil update dan masuk ke halaman kategori
    echo "<script>
        alert('Data kategori berhasil di update');
        window.location='../admin/kategori.php';
    </script>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <title>Edit kategori | admin</title>
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">

            <!--header card-->
            <div class="card-header bg-warning text-dark">
                Edit kategori
            </div>

            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label>Nama kategori</label>
                        <input type="text"
                            name="ket_kategori"
                            class="form-control"
                            value="<?= $nama ?>"
                            required>
                    </div>

                    <!--tombol simpan-->
                    <button type="submit" name="update" class="btn btn-success">
                        Simpan
                    </button>

                    <!--tombol kembali-->
                    <a href="../admin/kategori.php" class="btn btn-secondary">
                        Kembali
                    </a>
                </form>

            </div>

        </div>

    </div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>