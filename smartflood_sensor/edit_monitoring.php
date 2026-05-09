<?php
require 'koneksi.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM monitoring WHERE id='$id'"));

if (isset($_POST['update'])) {
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

    $foto = $data['foto_bukti'];

    if (!empty($_FILES['foto_bukti']['name'])) {
        if (file_exists("uploads/" . $foto)) {
            unlink("uploads/" . $foto);
        }

        $foto = $_FILES['foto_bukti']['name'];
        $tmp = $_FILES['foto_bukti']['tmp_name'];
        move_uploaded_file($tmp, "uploads/" . $foto);
    }

    mysqli_query($conn, "UPDATE monitoring SET
        lokasi_sungai='$lokasi',
        waktu_pengukuran='$waktu',
        tinggi_air='$tinggi',
        status_banjir='$status',
        deskripsi='$deskripsi',
        foto_bukti='$foto'
        WHERE id='$id'");

    header("Location: monitoring.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Monitoring</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<main>
<?php include 'navbar.php'; ?>

<div class="container">
    <div class="card form-card-wide">
        <h2>Edit Data Monitoring</h2>

        <form method="POST" enctype="multipart/form-data">
            <label>Lokasi Sungai</label>
            <input type="text" name="lokasi_sungai" value="<?= $data['lokasi_sungai']; ?>" required>

            <label>Waktu Pengukuran</label>
            <input type="datetime-local" name="waktu_pengukuran" value="<?= date('Y-m-d\TH:i', strtotime($data['waktu_pengukuran'])); ?>" required>

            <label>Tinggi Air (cm)</label>
            <input type="number" name="tinggi_air" value="<?= $data['tinggi_air']; ?>" required>

            <label>Deskripsi Kondisi</label>
            <textarea name="deskripsi" rows="5" required><?= $data['deskripsi']; ?></textarea>

            <label>Foto Lama</label>
            <br><br>
            <img src="uploads/<?= $data['foto_bukti']; ?>" width="150" class="preview-img">
            <br><br>

            <label>Upload Foto Baru (opsional)</label>
            <input type="file" name="foto_bukti" accept=".jpg,.jpeg,.png">

            <button type="submit" name="update">Simpan</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
</main>
</html>