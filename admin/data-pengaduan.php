<?php
    session_start();

    include "../koneksi.php";

    // pagination
    $limit = 10;

    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    $start = ($page - 1) * $limit;

    // search
    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
 
    $whereClause = '';
    if (!empty($search)) {
        $whereClause = "WHERE (
            s.nis       LIKE '%$search%' OR
            s.nama      LIKE '%$search%' OR
            s.kelas     LIKE '%$search%' OR
            k.ket_kategori LIKE '%$search%' OR
            ia.lokasi   LIKE '%$search%' OR
            ia.ket      LIKE '%$search%' OR
            IFNULL(a.status, 'menunggu') LIKE '%$search%'
        )";
    }

    if (!isset($_SESSION['admin'])) {
        header ("location: login.php");
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
    <title>Data pengaduan</title>
</head>
<body class="bg-light">
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
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fa-solid fa-comment"></i>Data pengaduan sarana</h5>
            </div>

            <div class="card-body">

                <!-- Search Form -->
                <form method="GET" action="" class="mb-3">
                    <div class="input-group" style="max-width: 400px;">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control" 
                            placeholder="Cari NIS, nama, kelas, kategori, lokasi..."
                            value="<?= htmlspecialchars($search); ?>"
                        >
                        <button class="btn btn-primary" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i> Cari
                        </button>
                        <?php if (!empty($search)) : ?>
                            <a href="?" class="btn btn-secondary">
                                <i class="fa-solid fa-xmark"></i> Reset
                            </a>
                        <?php endif; ?>
                    </div>
                </form>

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
                                <th>Lokasi</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $no = $start + 1;

                                $query = mysqli_query($conn, "
                                SELECT 
                                ia. id_pelaporan,
                                ia. tanggal,
                                S. nis,
                                s. kelas,
                                s. nama, 
                                k. ket_kategori,
                                ia. lokasi,
                                ia. ket,
                                IFNULL (a.status, 'menunggu') AS status
                                FROM input_aspirasi ia
                                -- ia = alias tabel input_aspirasi

                                JOIN siswa s ON ia.nis = s.nis
                                -- menggabungkan tabel siswa berdasarkan NIS

                                JOIN kategori k ON ia.id_kategori = k.id_kategori

                                LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan

                                $whereClause

                                ORDER BY ia.tanggal ASC

                                LIMIT $start, $limit
                                ");

                                $total = mysqli_query($conn, "
                                    SELECT COUNT(*) as total 
                                    FROM input_aspirasi ia
                                    JOIN siswa s ON ia.nis = s.nis
                                    JOIN kategori k ON ia.id_kategori = k.id_kategori
                                    LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                                    $whereClause
                                ");
                                
                                $totalData = mysqli_fetch_assoc($total)['total'];
                                $totalPage = ceil($totalData / $limit);

                                if (mysqli_num_rows($query) >0 ) {
                                
                                while ($row = mysqli_fetch_assoc($query) ) {
                                
                            ?>

                            
                            <tr>
                                <td class="text-center"><?= $no++; ?> </td>

                                <td class="text-center"><?= date('d-m-Y H:i', strtotime($row ['tanggal'])); ?> </td>

                                <td class="text-center"><?= $row['nis']; ?> </td>

                                <td class="text-center"><?= $row['nama']; ?></td>

                                <td class="text-center"><?= $row['kelas']; ?> </td>

                                <td class="text-center"><?= $row['ket_kategori']; ?> </td>

                                <td class="text-center"><?= $row['lokasi']; ?> </td>

                                <td class="text-center"><?= $row['ket']; ?> </td>

                                <td class="text-center">
                                    <?php
                                        if ($row['status'] == 'menunggu') {
                                            echo '<span class="badge bg-secondary"> Menunggu </span>';
                                        }elseif ($row['status'] == 'proses') {
                                            echo '<span class="badge bg-warning"> Proses </span>';
                                        }elseif ($row['status'] == 'selesai') {
                                            echo '<span class="badge bg-success"> Selesai </span>';
                                        }
                                    ?>
                                </td>

                                <!-- btn lihat dan hapus -->
                                <td class="text-center">
                                    <a href="lihat-pengaduan.php?id=<?= $row['id_pelaporan']; ?>" class="btn btn-info btn-sm">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a href="../proses/hapus-pengaduan.php?id=<?= $row['id_pelaporan']; ?>" class="btn btn-danger btn-sm"
                                    
                                        onclick="return confirm('Apakah anda yakin ingin menghapus pengaduan ini?')">
                                            <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>

                                <?php
                                }
                                }else {
                                    echo "<tr>
                                            <td colspan='10' class='text-center'>
                                                " . (!empty($search) 
                                                    ? "Data tidak ditemukan untuk pencarian \"<strong>" . htmlspecialchars($search) . "</strong>\"" 
                                                    : "Data belum tersedia") . "
                                            </td>
                                        </tr>";
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>

                    <nav>
                         <ul class="pagination justify-content-center">
 
                            <?php if ($page > 1) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>"> &lt; </a>
                                </li>
                            <?php endif; ?>
 
                            <?php for ($i = 1; $i <= $totalPage; $i++) : ?>
                                <?php if ($i == 1 || $i == $totalPage || abs($i - $page) <= 2) : ?>
                                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                                    </li>
                                    
                                <?php elseif (abs($i - $page) == 3) : ?>
                                    <li class="page-item disabled">
                                        <span class="page-link">...</span>
                                    </li>
                                <?php endif; ?>
                            <?php endfor; ?>
 
                            <?php if ($page < $totalPage) : ?>
                                <li class="page-item">
                                    <a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>"> &gt; </a>
                                </li>
                            <?php endif; ?>
 
                        </ul>
                    </nav>
                </div>
            </div>
            
        </div>

    </div>
<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>


