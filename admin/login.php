<?php
session_start();
include '../backend/koneksi.php';

if (isset($_POST['login'])) {
    $u = $_POST['username'];
    $p = md5($_POST['password']);
    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$u' AND password='$p'");
    if (mysqli_num_rows($cek) > 0) {
        $_SESSION['admin'] = $u;
        header('Location: dashboard.php');
    } else {
        $error = "Login gagal!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin | Sumber Agung</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #000;
            font-family: 'Open Sans', sans-serif;
            color: #fff;
        }
        .login-box {
            margin-top: 80px;
            background: #1a1a1a;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 10px #ffc107;
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
<div class="container d-flex justify-content-center">
    <div class="col-md-4 login-box">
        <h3 class="text-center mb-4">Login Admin</h3>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-yellow btn-block" name="login">Masuk</button>
        </form>
    </div>
</div>
</body>
</html>
