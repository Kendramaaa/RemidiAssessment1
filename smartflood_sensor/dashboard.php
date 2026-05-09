<?php
require 'koneksi.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$nama = $_SESSION['nama'];

$total = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM monitoring WHERE user_id='$user_id'"));

$aman = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM monitoring WHERE user_id='$user_id' AND status_banjir='Aman'"));

$waspada = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM monitoring WHERE user_id='$user_id' AND status_banjir='Waspada'"));

$bahaya = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM monitoring WHERE user_id='$user_id' AND status_banjir='Bahaya'"));

$latest = mysqli_query($conn,
"SELECT * FROM monitoring WHERE user_id='$user_id' ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="dashboard-container">
    <h1>Dashboard SmartFlood Sensor</h1>
    <p class="welcome">Selamat datang, <strong><?= $nama; ?></strong></p>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Monitoring</h3>
            <p><?= $total['total']; ?></p>
        </div>

        <div class="stat-card">
            <h3>Status Aman</h3>
            <p><?= $aman['total']; ?></p>
        </div>

        <div class="stat-card">
            <h3>Status Waspada</h3>
            <p><?= $waspada['total']; ?></p>
        </div>

        <div class="stat-card">
            <h3>Status Bahaya</h3>
            <p><?= $bahaya['total']; ?></p>
        </div>
    </div>

    <div class="table-card">
        <h2>Monitoring Terbaru</h2>
        <table>
            <tr>
                <th>Lokasi Sungai</th>
                <th>Waktu</th>
                <th>Tinggi Air</th>
                <th>Status</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($latest)) : ?>
            <tr>
                <td><?= $row['lokasi_sungai']; ?></td>
                <td><?= $row['waktu_pengukuran']; ?></td>
                <td><?= $row['tinggi_air']; ?> cm</td>
                <td><?= $row['status_banjir']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>