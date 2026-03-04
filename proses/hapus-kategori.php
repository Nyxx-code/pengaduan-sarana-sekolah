<?php
    session_start();

    include "../koneksi.php";

    //mengambil ID kategori dari parameter URL
    $id = $_GET['id'];

    //mengecek apakah kategori masih di gunakan data pengaduan
    $cek = mysqli_query($conn, " SELECT * FROM input_aspirasi WHERE id_kategori = '$id'");

    //jika jumlah database lebih dari 0 berarti kategori masih di gunakan
    if(mysqli_num_rows($cek) > 0) {

        //menampilkan pesan peringatan
        echo "<script>
                alert('Kategori tidak bisa dihapus karena masih digunakan di data pengaduan! '+
                'Hapus terlebih dahulu data yang terkait kategori ini di data pengaduan');
                window.location='../admin/kategori.php';
            </script>";
        exit;
    }

    //jika kategori tdk di gunakan, maka kategori dapat di hapus
    mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori = '$id'");

    //setelah berhasil dihapus,masuk ke halaman kategori
    header("location: ../admin/kategori.php");
    exit;
?>
