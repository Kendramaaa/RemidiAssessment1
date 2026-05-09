<?php
require 'koneksi.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$data = mysqli_query($conn,
"SELECT * FROM monitoring WHERE user_id='$user_id' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Monitoring</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main>
<?php include 'navbar.php'; ?>

<div class="dashboard-container">
    <div class="table-card">
        <h2>Data Monitoring Sungai</h2>
        <p><a href="tambah_monitoring.php" class="logout-btn">+ Tambah Monitoring</a></p>

        <table>
            <tr>
                <th>Lokasi Sungai</th>
                <th>Waktu</th>
                <th>Tinggi Air</th>
                <th>Status</th>
                <th>Deskripsi</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($data)) : ?>
            <tr>
                <td><?= $row['lokasi_sungai']; ?></td>
                <td><?= $row['waktu_pengukuran']; ?></td>
                <td><?= $row['tinggi_air']; ?> cm</td>
                <td><?= $row['status_banjir']; ?></td>
                <td><?= $row['deskripsi']; ?></td>
                <td>
                    <img src="uploads/<?= $row['foto_bukti']; ?>" width="80">
                </td>
                <td>
                    <a href="edit_monitoring.php?id=<?= $row['id']; ?>">Edit</a> |
                    <a href="hapus_monitoring.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus data?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>
</main>
</body>
</html>