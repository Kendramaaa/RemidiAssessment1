<?php
require 'koneksi.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['simpan'])) {
    $user_id = $_SESSION['user_id'];
    $lokasi = $_POST['lokasi_sungai'];
    $waktu = $_POST['waktu_pengukuran'];
    $tinggi = $_POST['tinggi_air'];
    $deskripsi = $_POST['deskripsi'];

    if ($tinggi <= 50) {
        $status = "Aman";
    } elseif ($tinggi <= 100) {
        $status = "Waspada";
    } else {
        $status = "Bahaya";
    }

    $foto = $_FILES['foto_bukti']['name'];
    $tmp = $_FILES['foto_bukti']['tmp_name'];
    move_uploaded_file($tmp, "uploads/" . $foto);

    mysqli_query($conn, "INSERT INTO monitoring
    (user_id,lokasi_sungai,waktu_pengukuran,tinggi_air,status_banjir,deskripsi,foto_bukti)
    VALUES
    ('$user_id','$lokasi','$waktu','$tinggi','$status','$deskripsi','$foto')");

    header("Location: monitoring.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Monitoring</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main>
<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card form-card-wide">
        <h2>Tambah Data Monitoring</h2>

        <form method="POST" enctype="multipart/form-data">
            <label>Lokasi Sungai</label>
            <input type="text" name="lokasi_sungai" required>

            <label>Waktu Pengukuran</label>
            <input type="datetime-local" name="waktu_pengukuran" required>

            <label>Tinggi Air (cm)</label>
            <input type="number" name="tinggi_air" required>

            <label>Deskripsi Kondisi</label>
            <textarea name="deskripsi" rows="5" required></textarea>

            <label>Foto Bukti</label>
            <input type="file" name="foto_bukti" accept=".jpg,.jpeg,.png" required>

            <button type="submit" name="simpan">Simpan Data</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
</main>
</body>
</html>