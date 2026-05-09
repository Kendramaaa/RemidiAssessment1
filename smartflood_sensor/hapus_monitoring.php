<?php
require 'koneksi.php';
$id = $_GET['id'];

$data = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM monitoring WHERE id='$id'"));

unlink("uploads/" . $data['foto_bukti']);
mysqli_query($conn, "DELETE FROM monitoring WHERE id='$id'");

header("Location: monitoring.php");
exit;
?>