<?php
    session_start();
    include "../koneksi.php";

    // pagination
    $limit = 10;

    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    $start = ($page - 1) * $limit;


    //proteksi login siswa
    if (!isset($_SESSION['siswa'])) {
        header("location: login-siswa.php");
        exit;
    }

    $nis = $_SESSION['siswa']['nis'];

    //ambil data pengaduan siswa
    $query = mysqli_query($conn, "
    SELECT
        ia.id_pelaporan,
        ia.tanggal,
        s.nis,
        s.nama,
        s.kelas,
        k.ket_kategori,
        ia.ket AS pengaduan,
        a.status,
        a.feedback
    FROM input_aspirasi ia
    JOIN siswa s ON ia.nis = s.nis
    JOIN kategori k ON ia.id_kategori = k.id_kategori
    LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
    WHERE ia.nis = '$nis'
    ORDER BY ia.tanggal ASC
    LIMIT $start, $limit
    ");

    $total = mysqli_query($conn, "SELECT COUNT(*) as total FROM input_aspirasi WHERE nis = '$nis'");
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
    <title>Riwayat pengaduan siswa</title>
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-success">
        <div class="container-fluid">
            <span class="navbar-brand">
                <i class="fa-solid fa-graduation-cap"></i> Pengaduan Sarana Sekolah - Siswa
            </span>
            
            <a href="index-siswa.php" class="btn btn-light btn-sm me-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>

        </div>
    </nav>
    
    <div class="container mt-4">
        <div class="card shadow-sm border-1 p-3">

            <h5 class="mb-0 mt-2">
                <i class="fa-solid fa-list"></i> Riwayat Pengaduan
            </h5>
        

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Kategori</th>
                                <th>Pengaduan</th>
                                <th>Status</th>
                                <th>Feedback</th>
                                <th>Aksi</th>
                            </tr>

                        </thead>

                        <tbody>
                            <?php
                                $no = $start + 1;
                                if (mysqli_num_rows($query) > 0) {
                                    while ($row = mysqli_fetch_assoc($query)) {

                            ?>

                            <tr>
                                <td class="text-center"><?= $no++; ?> </td>
                                <td class="text-center"> <?= date('d-m-Y H:i', strtotime($row['tanggal'])); ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['nis']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['nama']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['kelas']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['ket_kategori']) ?></td>
                                <td class="text-center"><?= htmlspecialchars($row['pengaduan']) ?></td>

                                <td class="text-center"> 
                                    <?php
                                        if ($row['status'] == 'menunggu') {
                                            echo '<span class="badge bg-secondary">Menunggu</span>';
                                        } elseif ($row['status'] == 'proses') {
                                            echo '<span class="badge bg-warning text-dark">Proses</span>';
                                        } elseif ($row['status'] == 'selesai') {
                                            echo '<span class="badge bg-success">Selesai</span>';
                                        } else {
                                            echo '<span class="badge bg-dark">-</span>';
                                        }
                                    ?>
                                </td>

                                <td class="text-center"> <?= $row['feedback'] ?: '-'; ?> </td>

                                <td class="text-center">
                                    <a href="../proses/hapus-laporan.php?id=<?= $row['id_pelaporan']; ?>" 
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin ingin menghapus laporan ini?')">
                                    <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                                
                            </tr>

                            <?php
                                    }
                                }else{
                                    echo "<tr> <td colspan='9' class='text-center'>Belum ada pengaduan </td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>

                    <nav>
                        <ul class="pagination justify-content-center">

                            <!-- // Tombol < (sebelumnya) - muncul jika bukan halaman 1 -->
                            <?php if($page > 1) : ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $page-1 ?>"> &lt; </a>
                            </li>
                            <?php endif; ?>

                            <!--pagination ellipsis  -->
                            <?php for($i=1; $i <= $totalPage; $i++) : ?>
                                <?php if ($i == 1 || $i == $totalPage || abs($i - $page) <= 2) : ?>

                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                    </li>

                                    <?php elseif (abs($i - $page) == 3) : ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>

                                <?php endif; ?>
                            <?php endfor; ?>

                            <!-- Tombol > (selanjutnya) - muncul jika bukan halaman terakhir -->
                            <?php if($page < $totalPage) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page+1 ?>"> &gt; </a>
                                </li>

                            <?php endif; ?>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>

    </div>
</body>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</html>