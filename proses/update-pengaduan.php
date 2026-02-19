<?php
    session_start();

    include "../koneksi.php";

    //proteksi admin
    if(!isset($_SESSION['admin'])) {
        header("location: ../admin/login.php");
        exit;
    }   

    //validasi apakah user menekan simpan
    if(!isset($_POST['simpan'])) {
        header("location: ../admin/data-pengaduan.php");
        exit;
    }

    //ambil data dari form lihat pengaduan
    $id_pelaporan = mysqli_real_escape_string($conn, $_POST['id_pelaporan']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    //cek data aspirasi berdasarkan id_pelaporan
    $cek = mysqli_query($conn, "
        SELECT * FROM aspirasi 
        WHERE id_pelaporan = '$id_pelaporan'
    ");

    //update data
    if (mysqli_num_rows($cek) > 0 ) {
            mysqli_query($conn, "
                UPDATE aspirasi SET
                    status = '$status',
                    feedback = '$feedback'
                WHERE id_pelaporan = '$id_pelaporan'
                ");
                
    }else{
        //insert 
        mysqli_query($conn, "
            INSERT INTO aspirasi (id_pelaporan, status, feedback)
            VALUES ('$id_pelaporan', '$status', '$feedback')
        ");
    }

    header("location: ../admin/data-pengaduan.php");
    exit;
        
?>