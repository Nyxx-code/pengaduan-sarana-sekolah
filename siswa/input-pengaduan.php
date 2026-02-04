<?php
    session_start();

    include "../koneksi.php";

    if(!isset($_SESSION['siswa'])) {
        header("location: login-siswa.php");
        exit;
    }

    //ambil data dari tabel kategori dari database
    $siswa = $_SESSION['siswa'];
    $kategori = mysqli_query(
        $conn, "SELECT * FROM kategori"
    );
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <title>Buat pengaduan</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-success">
        <div class="container-fluid">
            <a href="index-siswa.php" class="navbar-brand">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>

            <span class="navbar-text text-white">
                <p><b>NIS :</b>  <?= $siswa['nis']; ?> <b>Kelas</b> <?= $siswa['kelas']; ?> </p>
            </span>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow-sm">
            <h5 class="mb-0">
                 <i class="fa-solid fa-plus"></i> Form pengaduan siswa
            </h5>
       

        <div class="card-body">
            <form method="POST"action="../proses/simpan-pengaduan.php">
                <div class="mb-3">
                    <label class="form-label">Kategori sarana: </label>
                    <select name="id_kategori" class="form-select" required>
                        <option value="">--Silakan pilih kategori sarana</option>

                        <?php while ($k = mysqli_fetch_assoc($kategori)) { ?>

                       <option value="<?= $k['id_kategori']; ?>">
                            <?= $k['ket_kategori']; ?>
                            <?php } ?>
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi pengaduan</label>
                    <textarea name="ket" class="form-control" rows="4" required></textarea>
                </div>
            </form>
        </div>

        <div class="d-flex justify-content-between">
            <button class="btn btn-light"><a href="index-siswa.php">
                <i class="fa-solid fa-arrow-left"></i> Batal
            </a>
            </button>

            <button type="submit" name="kirim" class="btn btn-success">
                Kirim pengaduan
            </button>
        </div>
    </div>
 </div>

</div>
</body>
</html>