<?php
    session_start();

    include "../koneksi.php";

    //proteksi halaman

    if(!isset($_SESSION['admin'])) {
        header ("location: login.php");
        exit;
    }

    //ambil data pengaduan menurut ID pelaporan

    if (!isset($_GET['id'])) {
        header ("location: data-pengaduan.php");
        exit;
    }

    $id = $_GET['id'];

    //ambil data pengaduan berdasarkan query
    $query = mysqli_query($conn, "
        SELECT 
            ia. id_pelaporan,
            ia. id_kategori,
            s. nis,
            s.nama,
            s. kelas,
            k. ket_kategori,
            ia. lokasi,
            ia. ket,
            IFNULL (a.status, 'menunggu') AS status,
            IFNULL (a.feedback, '') AS feedback
        FROM input_aspirasi ia
        JOIN siswa s ON ia.nis = s.nis
        JOIN kategori k ON ia.id_kategori = k.id_kategori
        LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
        WHERE ia.id_pelaporan = '$id'
    ");

    $data = mysqli_fetch_assoc($query);

    if (!$data) {
        header("location: data-pengaduan.php");
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
    <!-- navbar -->
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

                <a href="data-pengaduan.php" class="btn btn-light btn-sm me-2">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </a>

                <a href="../proses/logout.php" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    Detail Pengaduan
                </h5>
            </div>

            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th width="38%">NIS</th>
                        <td><?= $data['nis']; ?></td>
                    </tr>

                    <tr>
                        <th>Nama</th>
                        <td><?= $data['nama']; ?> </td>
                    </tr>

                    <tr>
                        <th>Kelas</th>
                        <td><?= $data['kelas']; ?> </td>
                    </tr>

                    <tr>
                        <th>Kategori</th>
                        <td><?= $data['ket_kategori']; ?> </td>
                    </tr>

                    <tr>
                        <th>Lokasi</th>
                        <td><?= $data['lokasi']; ?> </td>
                    </tr>

                    <tr>
                        <th>Keterangan</th>
                        <td><?= $data['ket']; ?> </td>
                    </tr>

                </table>

                <!-- Form status & feedback -->
                <form method="post" action="../proses/update-pengaduan.php">
                    <input type="hidden" name="id_pelaporan" value="<?= $data['id_pelaporan']; ?>">
                    <input type="hidden" name="id_kategori" value="<?= $data['id_kategori']; ?>">

                    <div class="mb-3">
                        <label class="form-label"><strong>Status Pengaduan</strong></label>
                        <select name="status" class="form-select" required>
                           <option value="Menunggu" <?= ($data['status'] == 'Menunggu') ? 'selected' : ''; ?>> Menunggu </option>
                           <option value="Proses" <?= ($data['status'] == 'Proses') ? 'selected' : ''; ?>> Proses </option>
                           <option value="Selesai" <?= ($data['status'] == 'Selesai') ? 'selected' : ''; ?>> Selesai </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Feedback</label>
                        <textarea name="feedback" class="form-control" rows="3" required><?= $data['feedback']; ?></textarea>
                    </div>

                        <button class="btn btn-success" type="submit" name="simpan">
                            Simpan
                        </button>

                    </div>
                </form>

            </div>

        </div>
    </div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>