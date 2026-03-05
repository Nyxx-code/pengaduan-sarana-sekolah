<?php
    session_start();

    //cek login admin
    if(!isset($_SESSION['admin'])) {
        header("location: login.php");
        exit;
    }

    // koneksi database
    include "../koneksi.php";

    //ambil data dari database
    $datasiswa = mysqli_query($conn, "SELECT * FROM siswa ORDER BY nis ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/fontawesome/css/all.min.css">
    <title>Tambah siswa | admin</title>
</head>
<body class="bg-light">

    <!--navbar-->
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

                <!-- tombol kembali -->
                <div class="d-flex">
                    <a href="index-admin.php" class="btn btn-light btn-sm me-2">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                </div>

                    <a href="../proses/logout.php" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        <!--notifikasi-->
        <?php
        if(isset($_SESSION['success'])) : ?>

        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa-solid fa-circle-check"></i><?= $_SESSION['success']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

        <?php unset($_SESSION['success']); endif; ?>

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form tambah siswa</h5>
            </div>

            <!--form menambahkan nis dan kelas-->
            <div class="card-body">
                <form method="post" action="../proses/tambah-siswa.php">
                    <div class="mb-3">
                        <label class="form-label">NIS</label>
                        <input type="text" name="nis" class="form-control" placeholder="Masukkan NIS siswa" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama siswa" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kelas</label>
                        <input type="text" name="kelas" class="form-control" placeholder="Masukkan kelas siswa"required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" name="simpan" class="btn btn-success">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

            <!--Daftar akun siswa-->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Daftar siswa</h5>
                </div>

                
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nis</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                               <?php
                                    $no = 1;
                                    if(mysqli_num_rows($datasiswa) > 0) :
                                        while ($row = mysqli_fetch_assoc($datasiswa)) :
                                    ?>

                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td class="text-center"><?= htmlspecialchars($row['nis']); ?></td>
                                        <td class="text-center"><?= htmlspecialchars($row['nama']); ?></td>
                                        <td class="text-center"><?= htmlspecialchars($row['kelas']); ?></td>
                                        <td class="text-center">
                                            <a href="../proses/hapus-siswa.php?nis=<?= $row['nis']; ?>" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus siswa ini?')">
                                            <i class="fa-solid fa-trash"></i>
                                            </a>
                                        </td>

                                    </tr>

                                    <?php 
                                        endwhile;
                                    else:
                                ?>

                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data</td>
                                </tr>

                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>