<?php
require_once __DIR__ . '/../db.php';
$sql = "SELECT Kelompok AS KelompokBiaya, A.JenisProduk, A.NomorPesanan, SUM(Jumlah) AS JumlahBiaya
FROM KartuPesanan A
INNER JOIN RincianBiaya B ON A.NomorPesanan = B.NomorPesanan
GROUP BY A.NomorPesanan, A.JenisProduk, Kelompok
ORDER BY SUM(Jumlah) DESC
LIMIT 3";
$rows = $cnn->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTFs-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan H</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3>h. Top 3 Penggunaan Kelompok Biaya Terbesar</h3>
    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark"><tr><th>Kelompok Biaya</th><th>Jenis Produk</th><th>Nomor Pesanan</th><th>Jumlah Biaya</th></tr></thead>
        <tbody>
            <?php foreach($rows as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['KelompokBiaya']); ?></td>
                <td><?= htmlspecialchars($r['JenisProduk']); ?></td>
                <td><?= htmlspecialchars($r['NomorPesanan']); ?></td>
                <td class="text-end"><?= number_format($r['JumlahBiaya']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between mt-3">
    <a href="laporan_g.php" class="btn btn-primary">← Previous</a>
    <a href="../index.php" class="btn btn-secondary">Kembali</a>
    </div>
</div>
</body>
</html>
