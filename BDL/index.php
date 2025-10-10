<?php
include "db.php";
$sql = "SELECT * FROM KartuPesanan ORDER BY NomorPesanan ASC";
$stmt = $cnn->query($sql);
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Data Kartu Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<h2>Daftar Kartu Pesanan</h2>
<a href="views/laporan_a.php" class="btn btn-success mb-3">Laporan A-H</a>
<table class="table table-bordered table-striped">
<thead>
<tr>
  <th>Nomor Pesanan</th>
  <th>Jenis Produk</th>
  <th>Jumlah</th>
  <th>Tgl Pesan</th>
  <th>Tgl Selesai</th>
  <th>Dipesan Oleh</th>
  <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php foreach($data as $d): ?>
<tr>
  <td><?= $d['NomorPesanan'] ?></td>
  <td><?= $d['JenisProduk'] ?></td>
  <td><?= $d['JmlPesanan'] ?></td>
  <td><?= $d['TglPesanan'] ?></td>
  <td><?= $d['TglSelesai'] ?></td>
  <td><?= $d['DipesanOleh'] ?></td>
  <td>
    <a href="detail.php?id=<?= $d['NomorPesanan'] ?>" class="btn btn-info btn-sm">Detail</a>
    <a href="edit.php?id=<?= $d['NomorPesanan'] ?>" class="btn btn-warning btn-sm">Edit</a>
    <a href="delete.php?id=<?= $d['NomorPesanan'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</body>
</html>
