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
    <nav>
        
    </nav>
    
</body>
</html>