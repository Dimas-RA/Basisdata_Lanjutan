<?php
require_once __DIR__ . '/../db.php';
$sql = "SELECT A.NomorPesanan, JenisProduk, JmlPesanan, SUM(Jumlah) AS BiayaLangsung,
SUM(Jumlah) * 30/100 AS BiayaOverHead,
SUM(Jumlah) * 130/100 AS TotalBiaya,
(SUM(Jumlah) * 130/100) / JmlPesanan AS BiayaPerUnit
FROM KartuPesanan A
INNER JOIN RincianBiaya B ON A.NomorPesanan = B.NomorPesanan
GROUP BY A.NomorPesanan, JenisProduk, JmlPesanan
ORDER BY A.NomorPesanan, JenisProduk, JmlPesanan";
$rows = $cnn->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan D</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3>d. Penghitungan Biaya Produk per Pesanan</h3>
    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark">
            <tr><th>Nomor Pesanan</th><th>Jenis Produk</th><th>Jml Pesanan</th><th>Biaya Langsung</th><th>Overhead</th><th>Total Biaya</th><th>Biaya / Unit</th></tr>
        </thead>
        <tbody>
            <?php foreach($rows as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['NomorPesanan']); ?></td>
                <td><?= htmlspecialchars($r['JenisProduk']); ?></td>
                <td><?= htmlspecialchars($r['JmlPesanan']); ?></td>
                <td class="text-end"><?= number_format($r['BiayaLangsung']); ?></td>
                <td class="text-end"><?= number_format($r['BiayaOverHead']); ?></td>
                <td class="text-end"><?= number_format($r['TotalBiaya']); ?></td>
                <td class="text-end"><?= number_format($r['BiayaPerUnit'],2); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between mt-3">
    <a href="laporan_c.php" class="btn btn-secondary">← Previous</a>
    <a href="laporan_e.php" class="btn btn-primary">Next →</a>
    </div>
</div>
</body>
</html>