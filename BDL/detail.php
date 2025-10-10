<?php
include "db.php";
$id = $_GET['id'] ?? null;

if (!$id) {
    die("ID tidak ditemukan.");
}

$sql = "SELECT * FROM KartuPesanan WHERE NomorPesanan = ?";
$stmt = $cnn->prepare($sql);
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Detail Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<h2>Detail Pesanan #<?= $data['NomorPesanan'] ?></h2>
<table class="table table-bordered">
<tr><th>Nomor Pesanan</th><td><?= $data['NomorPesanan'] ?></td></tr>
<tr><th>Jenis Produk</th><td><?= $data['JenisProduk'] ?></td></tr>
<tr><th>Jumlah Pesanan</th><td><?= $data['JmlPesanan'] ?></td></tr>
<tr><th>Tanggal Pesan</th><td><?= $data['TglPesanan'] ?></td></tr>
<tr><th>Tanggal Selesai</th><td><?= $data['TglSelesai'] ?></td></tr>
<tr><th>Dipesan Oleh</th><td><?= $data['DipesanOleh'] ?></td></tr>
</table>
<a href="index.php" class="btn btn-secondary">Kembali</a>
</body>
</html>
