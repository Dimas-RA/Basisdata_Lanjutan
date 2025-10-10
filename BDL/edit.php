<?php
include "db.php";

$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "SELECT * FROM KartuPesanan WHERE NomorPesanan = ?";
    $stmt = $cnn->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $JenisProduk = $_POST['JenisProduk'];
    $JmlPesanan = $_POST['JmlPesanan'];
    $TglPesanan = $_POST['TglPesanan'];
    $TglSelesai = $_POST['TglSelesai'];
    $DipesanOleh = $_POST['DipesanOleh'];

    $sql_update = "UPDATE KartuPesanan 
                   SET JenisProduk=?, JmlPesanan=?, TglPesanan=?, TglSelesai=?, DipesanOleh=? 
                   WHERE NomorPesanan=?";
    $stmt = $cnn->prepare($sql_update);
    $stmt->execute([$JenisProduk, $JmlPesanan, $TglPesanan, $TglSelesai, $DipesanOleh, $id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Edit Data Pesanan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<h2>Edit Pesanan #<?= $id ?></h2>

<form method="post">
  <div class="mb-3">
    <label class="form-label">Jenis Produk</label>
    <input type="text" name="JenisProduk" class="form-control" value="<?= $data['JenisProduk'] ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Jumlah Pesanan</label>
    <input type="number" name="JmlPesanan" class="form-control" value="<?= $data['JmlPesanan'] ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Tanggal Pesan</label>
    <input type="date" name="TglPesanan" class="form-control" value="<?= $data['TglPesanan'] ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Tanggal Selesai</label>
    <input type="date" name="TglSelesai" class="form-control" value="<?= $data['TglSelesai'] ?>">
  </div>
  <div class="mb-3">
    <label class="form-label">Dipesan Oleh</label>
    <input type="text" name="DipesanOleh" class="form-control" value="<?= $data['DipesanOleh'] ?>">
  </div>
  <button type="submit" class="btn btn-primary">Simpan</button>
  <a href="index.php" class="btn btn-secondary">Batal</a>
</form>

</body>
</html>
