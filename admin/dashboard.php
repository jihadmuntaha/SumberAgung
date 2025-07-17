<?php
session_start();
if (!isset($_SESSION['admin']))
    header("Location: login.php");
include '../backend/koneksi.php';

// Handle filter kategori
$filter = '';
if (isset($_GET['kategori']) && $_GET['kategori'] != '') {
    $kategori = mysqli_real_escape_string($conn, $_GET['kategori']);
    $filter = "WHERE kategori='$kategori'";
}

$data = mysqli_query($conn, "SELECT * FROM menu $filter ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin | Sumber Agung</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #111;
            color: #fff;
            font-family: 'Open Sans', sans-serif;
        }

        .btn-yellow {
            background-color: #ffc107;
            color: #000;
        }

        .btn-yellow:hover {
            background-color: #e0a800;
        }

        .img-thumb {
            max-height: 100px;
            border-radius: 8px;
        }

        th,
        td {
            vertical-align: middle !important;
        }

        .table thead th {
            background-color: #222;
            color: #ffc107;
        }

        .badge {
            font-size: 90%;
        }

        .form-inline select {
            width: 200px;
        }

        .header-title {
            color: #ffc107;
        }
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="header-title mb-0">Dashboard Menu</h2>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="add_menu.php" class="btn btn-yellow">+ Tambah Menu</a>
            <form method="get" class="form-inline">
                <label for="kategori" class="mr-2 text-white">Filter kategori:</label>
                <select name="kategori" id="kategori" class="form-control" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="minuman" <?= isset($_GET['kategori']) && $_GET['kategori'] == 'minuman' ? 'selected' : '' ?>>Minuman</option>
                    <option value="makanan" <?= isset($_GET['kategori']) && $_GET['kategori'] == 'makanan' ? 'selected' : '' ?>>Makanan</option>
                    <option value="jajanan" <?= isset($_GET['kategori']) && $_GET['kategori'] == 'jajanan' ? 'selected' : '' ?>>Jajanan</option>
                </select>
            </form>
        </div>

        <table class="table table-dark table-hover table-bordered text-center">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga Asli</th>
                    <th>Diskon</th>
                    <th>Harga Setelah Diskon</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                while ($d = mysqli_fetch_assoc($data)):
                    $diskon = intval($d['diskon']);
                    $hargaDiskon = $diskon > 0 ? $d['harga'] - ($d['harga'] * $diskon / 100) : $d['harga'];
                    ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($d['nama']) ?></td>
                        <td><?= ucfirst($d['kategori']) ?></td>
                        <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                        <td>
                            <?php if ($diskon > 0): ?>
                                <span class="badge badge-success"><?= $diskon ?>%</span>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif ?>
                        </td>
                        <td>Rp <?= number_format($hargaDiskon, 0, ',', '.') ?></td>
                        <td><img src="upload/<?= htmlspecialchars($d['gambar']) ?>" class="img-thumb"></td>
                        <td>
                            <a href="edit_menu.php?id=<?= $d['id'] ?>" class="btn btn-sm btn-warning mb-1">Edit</a>
                            <a href="delete_menu.php?id=<?= $d['id'] ?>"
                                onclick="return confirm('Yakin ingin menghapus menu ini?')"
                                class="btn btn-sm btn-danger">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile ?>
            </tbody>
        </table>
    </div>
</body>

</html>