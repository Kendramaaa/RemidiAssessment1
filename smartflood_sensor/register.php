<?php
require 'koneksi.php';

if (isset($_POST['register'])) {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($nama) || empty($email) || empty($password)) {
        echo "<script>alert('Semua field wajib diisi');</script>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Email tidak valid');</script>";
    } elseif (strlen($password) < 6) {
        echo "<script>alert('Password minimal 6 karakter');</script>";
    } else {
        $password = password_hash($password, PASSWORD_DEFAULT);
        mysqli_query($conn, "INSERT INTO users (nama,email,password)
        VALUES ('$nama','$email','$password')");

        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <div class="card">
        <h2>Register SmartFlood</h2>
        <form method="POST">
            <label>Nama Lengkap</label>
            <input type="text" name="nama" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="register">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</div>
</body>
</html>