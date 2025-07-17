<?php
session_start();
if (!isset($_SESSION['admin']))
    header("Location: login.php");
include '../backend/koneksi.php';

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM menu WHERE id=$id"));

if (isset($_POST['update'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $diskon = $_POST['diskon'];

    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        move_uploaded_file($_FILES['gambar']['tmp_name'], "upload/" . $gambar);
        mysqli_query($conn, "UPDATE menu SET nama='$nama', harga='$harga', kategori='$kategori', diskon='$diskon', gambar='$gambar' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE menu SET nama='$nama', harga='$harga', kategori='$kategori', diskon='$diskon' WHERE id=$id");
    }

    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Menu | Sumber Agung</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;600;700&display=swap" rel="stylesheet">
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

        .form-label {
            font-weight: 600;
        }

        .container-box {
            max-width: 600px;
            margin: 50px auto;
            background: #1c1c1c;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body>
    <div class="container-box">
        <h3 class="mb-4 text-center">Edit Menu: <span class="text-warning"><?= htmlspecialchars($data['nama']) ?></span>
        </h3>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>"
                    required>
            </div>
            <div class="form-group">
                <label class="form-label">Harga</label>
                <input type="number" name="harga" class="form-control" value="<?= intval($data['harga']) ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Diskon (%)</label>
                <input type="number" name="diskon" class="form-control" min="0" max="100"
                    value="<?= intval($data['diskon']) ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-control" required>
                    <option value="minuman" <?= $data['kategori'] == 'minuman' ? 'selected' : '' ?>>Minuman</option>
                    <option value="makanan" <?= $data['kategori'] == 'makanan' ? 'selected' : '' ?>>Makanan</option>
                    <option value="jajanan" <?= $data['kategori'] == 'jajanan' ? 'selected' : '' ?>>Jajanan</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Ganti Gambar (opsional)</label><br>
                <img src="upload/<?= $data['gambar'] ?>" width="120" class="mb-2 rounded" id="gambarLama">
                <input type="file" name="gambar" class="form-control-file" id="gambarInput"
                    onchange="previewImage(event)">
                <img id="previewBaru" class="mb-2 rounded mt-2" style="max-width: 120px; display: none;">
            </div>
            <div class="d-flex justify-content-between mt-4">
                <button type="submit" name="update" class="btn btn-yellow"><i class="fa fa-save"></i> Simpan</button>
                <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview