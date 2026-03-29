<?php
session_start();

// cek login admin
if(!isset($_SESSION['admin'])) {
    header("location: login.php");
    exit;
}

// koneksi database
include "../koneksi.php";

// pagination
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// ambil keyword search
$keyword = isset($_GET['keyword']) ? mysqli_real_escape_string($conn, $_GET['keyword']) : '';

// query dengan search
if(!empty($keyword)) {
    $query = "SELECT * FROM siswa 
              WHERE nis LIKE '%$keyword%' 
              OR nama LIKE '%$keyword%' 
              OR kelas LIKE '%$keyword%'
              ORDER BY nis ASC 
              LIMIT $start, $limit";

    $queryTotal = "SELECT COUNT(*) as total FROM siswa 
                   WHERE nis LIKE '%$keyword%' 
                   OR nama LIKE '%$keyword%' 
                   OR kelas LIKE '%$keyword%'";
} else {
    $query = "SELECT * FROM siswa 
              ORDER BY nis ASC 
              LIMIT $start, $limit";

    $queryTotal = "SELECT COUNT(*) as total FROM siswa";
}

$datasiswa = mysqli_query($conn, $query);
$total     = mysqli_query($conn, $queryTotal);
$totalData = mysqli_fetch_assoc($total)['total'];
$totalPage = ceil($totalData / $limit);
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

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container-fluid">
        <span class="navbar-brand fw-bold">
            <i class="fa-solid fa-school"></i> Pengaduan Sarana Sekolah - Admin
        </span>

        <div class="d-flex">
            <span class="text-white me-3">
                <i class="fa-solid fa-user"></i>
                <?= $_SESSION['admin']; ?>
            </span>

            <a href="index-admin.php" class="btn btn-light btn-sm me-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>

            <a href="../proses/logout.php" class="btn btn-danger btn-sm">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </a>
        </div>
    </div>
</nav>

<div class="container mt-4">

    <!-- FORM TAMBAH -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form tambah siswa</h5>
        </div>

        <div class="card-body">
            <form method="post" action="../proses/tambah-siswa.php">
                <div class="mb-3">
                    <label>NIS</label>
                    <input type="text" name="nis" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Kelas</label>
                    <input type="text" name="kelas" class="form-control" required>
                </div>

                <button type="submit" name="simpan" class="btn btn-success w-100">
                    Simpan
                </button>
            </form>
        </div>
    </div>

    <!-- TABEL -->
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Daftar siswa</h5>
        </div>

        <div class="card-body">

            <!-- SEARCH -->
            <form method="GET" class="mb-3 d-flex">
                <input type="text" name="keyword" class="form-control me-2"
                       placeholder="Cari NIS / Nama / Kelas..."
                       value="<?= $keyword ?>">

                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> Cari
                </button>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered text-center">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = $start + 1;
                        if(mysqli_num_rows($datasiswa) > 0) :
                            while ($row = mysqli_fetch_assoc($datasiswa)) :
                        ?>

                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nis']); ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['kelas']); ?></td>
                            <td>
                                <a href="edit-siswa.php?nis=<?= $row['nis']; ?>" class="btn btn-warning btn-sm">
                                    <i class="fa fa-pen"></i>
                                </a>

                                <a href="../proses/hapus-siswa.php?nis=<?= $row['nis']; ?>"
                                   class="btn btn-danger btn-sm"
                                   onclick="return confirm('Yakin hapus?')">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>

                        <?php endwhile; else: ?>
                        <tr>
                            <td colspan="5">Tidak ada data</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <!-- PAGINATION -->
                <ul class="pagination justify-content-center">

                    <?php if($page > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page-1 ?>&keyword=<?= $keyword ?>">&lt;</a>
                    </li>
                    <?php endif; ?>

                    <?php for($i=1; $i <= $totalPage; $i++) : ?>
                        <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&keyword=<?= $keyword ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <?php if($page < $totalPage) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page+1 ?>&keyword=<?= $keyword ?>">&gt;</a>
                    </li>
                    <?php endif; ?>

                </ul>

            </div>
        </div>
    </div>
</div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>