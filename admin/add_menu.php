<?php
session_start();
if (!isset($_SESSION['admin']))
    header("Location: login.php");
include '../backend/koneksi.php';

if (isset($_POST['save'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $kategori = $_POST['kategori'];
    $diskon = $_POST['diskon'];
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "upload/" . $gambar);

    mysqli_query($conn, "INSERT INTO menu (nama, harga, kategori, diskon, gambar) 
                         VALUES ('$nama','$harga','$kategori','$diskon','$gambar')");
    header("Location: dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Tambah Menu | Sumber Agung</title>
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
    </style>
</head>

<body>
    <div class="container py-5">
        <h2>Tambah Menu Baru</h2>
        <form method="post" enctype="multipart/form-data" class="mt-4">
            <div class="form-group">
                <label>Nama Menu</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Diskon (%)</label>
                <input type="number" name="diskon" class="form-control" min="0" max="100" value="0">
            </div>
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control" required>
                    <option value="minuman">Minuman</option>
                    <option value="makanan">Makanan</option>
                    <option value="jajanan">Jajanan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control-file" id="gambarInput"
                    onchange="previewImage(event)">
                <img id="preview" src="#" class="mt-2" style="max-width: 200px; display: none;">
            </div>
            <button class="btn btn-yellow" name="save">Simpan</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
    <script>
        function previewImage(event) {
            var input = event.target;
            var preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(input.files[0]);
            preview.style.display = 'block';
        }
    </script>
</body>

</html>