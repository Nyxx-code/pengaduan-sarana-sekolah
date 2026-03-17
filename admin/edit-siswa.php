<?php
    session_start();
    include "../koneksi.php";

    if(!isset($_GET['nis'])){
        header("location: tambah-siswa.php");
        exit;
    }

    $nis = $_GET['nis'];

    $query = mysqli_query($conn,"SELECT * FROM siswa WHERE nis='$nis'");
    $data = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Siswa</title>
<link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">

        <div class="card shadow">
            <div class="card-header bg-warning">
                <h5>Edit Data Siswa</h5>
            </div>

            <div class="card-body">

                <form method="POST" action="../proses/edit-siswa.php">
                    <input type="hidden" name="nis" value="<?= $data['nis']; ?>">

                    <div class="mb-3">
                        <label>NIS</label>
                        <input type="text" class="form-control"
                        value="<?= $data['nis']; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="nama"
                        class="form-control"
                        value="<?= $data['nama']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label>Kelas</label>
                        <input type="text" name="kelas"
                        class="form-control"
                        value="<?= $data['kelas']; ?>" required>
                    </div>

                    <button type="submit" name="update"
                    class="btn btn-success">
                        Update
                    </button>

                    <a href="tambah-siswa.php"
                    class="btn btn-secondary">
                        Kembali
                    </a>

                </form>

            </div>
        </div>

    </div>

</body>
</html>