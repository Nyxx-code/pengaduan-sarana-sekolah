<?php
    session_start();
    include "../koneksi.php";

    if(!isset($_SESSION['admin'])) {
        header("location: login.php");
        exit;
    }

    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

    $whereClause = '';
    if (!empty($search)) {
        $whereClause = "WHERE ket_kategori LIKE '%$search%'";
    }

    // Bug 1 fix — query kedua dihapus, hanya pakai yang ada $whereClause
    $data = mysqli_query($conn, "
        SELECT * FROM kategori
        $whereClause
        ORDER BY id_kategori ASC
    ");

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
    <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <a href="index-admin.php" class="navbar-brand">
                <i class="fa-solid fa-tags"></i> Data Kategori
            </a>
            <div class="d-flex">
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
                <h5 class="mb-0">
                    <i class="fa-solid fa-list"></i> Kategori Sarana
                </h5>
            </div>

            <div class="card-body">

                <!-- Bug 2 fix — form tambah dan form search dipisah, tidak bersarang -->
                <form method="post" action="../proses/tambah-kategori.php" class="mb-3">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" 
                                name="ket_kategori" 
                                class="form-control" 
                                placeholder="Masukkan nama kategori baru" required
                            >
                        </div>
                        <div class="col-md-4 d-grid">
                            <button class="btn btn-success" name="simpan">
                                <i class="fa-solid fa-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>

                <form method="GET" action="" class="mb-3">
                    <div class="input-group" style="max-width: 400px;">
                        <input 
                            type="text" 
                            name="search" 
                            class="form-control" 
                            placeholder="Cari nama kategori..."
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
                    <table class="table table-bordered table-striped">
                        <thead class="table-light text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th>Nama Kategori</th>
                                <th width="20%">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $no = 1;
                                if (mysqli_num_rows($data) > 0) {
                                    while ($row = mysqli_fetch_assoc($data)) {
                            ?>

                            <tr>
                                <td class="text-center"><?= $no++; ?></td>

                                <td><?= $row['ket_kategori']; ?></td>

                                <td class="text-center">
                                    <a href="../proses/edit-kategori.php?id=<?= $row['id_kategori']; ?>&nama=<?= urlencode($row['ket_kategori']); ?>"
                                    class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <a href="../proses/hapus-kategori.php?id=<?= $row['id_kategori']; ?>"
                                    class="btn btn-sm btn-danger" onclick="return confirm('Hapus kategori ini?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>

                            <?php
                                    }
                                } else {
                                    // Bug 3 fix — pesan saat data kosong
                                    $pesan = !empty($search)
                                        ? "Kategori tidak ditemukan untuk pencarian \"<strong>" . htmlspecialchars($search) . "</strong>\""
                                        : "Data belum tersedia";

                                    echo "<tr><td colspan='3' class='text-center'>" . $pesan . "</td></tr>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>