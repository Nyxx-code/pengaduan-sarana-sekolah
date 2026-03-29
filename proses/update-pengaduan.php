<?php
    session_start();
    include "../koneksi.php";

    // proteksi admin
    if (!isset($_SESSION['admin'])) {
        header("location: ../admin/login.php");
        exit;
    }

    // validasi tombol simpan
    if (!isset($_POST['simpan'])) {
        header("location: ../admin/data-pengaduan.php");
        exit;
    }

    // ambil data
    $id_pelaporan = mysqli_real_escape_string($conn, $_POST['id_pelaporan']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    // validasi
    if ($status == "" || $feedback == "") {
        echo "<script>
                alert('Status dan feedback wajib diisi!');
                window.history.back();
            </script>";
        exit;
    }

    // ambil id_kategori dari input_aspirasi (FIX ERROR FOREIGN KEY)
    $getKategori = mysqli_query($conn, "
        SELECT id_kategori 
        FROM input_aspirasi 
        WHERE id_pelaporan = '$id_pelaporan'
    ");

    $dataKategori = mysqli_fetch_assoc($getKategori);
    $id_kategori = $dataKategori['id_kategori'];

    // cek apakah sudah ada di tabel aspirasi
    $cek = mysqli_query($conn, "
        SELECT * FROM aspirasi 
        WHERE id_pelaporan = '$id_pelaporan'
    ");

    if (mysqli_num_rows($cek) > 0) {
        // UPDATE
        mysqli_query($conn, "
            UPDATE aspirasi SET
                status = '$status',
                feedback = '$feedback'
            WHERE id_pelaporan = '$id_pelaporan'
        ");
    } else {
        // INSERT (sudah termasuk id_kategori)
        mysqli_query($conn, "
            INSERT INTO aspirasi (id_pelaporan, id_kategori, status, feedback)
            VALUES ('$id_pelaporan', '$id_kategori', '$status', '$feedback')
        ");
    }

    // redirect
    header("location: ../admin/data-pengaduan.php");
    exit;
?>