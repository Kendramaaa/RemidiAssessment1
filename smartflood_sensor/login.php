<?php
require 'koneksi.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];

        header("Location: dashboard.php");
        exit;
    } else {
        echo "<script>alert('Login gagal');</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container">
    <div class="card">
        <h2>Login SmartFlood</h2>
        <form method="POST">
            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" name="login">Masuk</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Register</a></p>
    </div>
</div>
</body>
</html>