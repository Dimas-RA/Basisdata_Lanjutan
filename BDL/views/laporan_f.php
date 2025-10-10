<?php
require_once __DIR__ . '/../db.php';
$sql = "SELECT A.NomorPesanan, JenisProduk, JmlPesanan, Kelompok, SUM(Jumlah) AS JumlahBiaya
FROM KartuPesanan A
INNER JOIN RincianBiaya B ON A.NomorPesanan = B.NomorPesanan
WHERE JenisProduk = 'Sepatu'
GROUP BY A.NomorPesanan, JenisProduk, JmlPesanan, Kelompok
ORDER BY A.NomorPesanan, JenisProduk, JmlPesanan, Kelompok";
$rows = $cnn->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan F</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3>f. Laporan Biaya Langsung (Jenis Produk = 'Sepatu')</h3>
    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark"><tr><th>Nomor Pesanan</th><th>Jenis Produk</th><th>Jml Pesanan</th><th>Kelompok</th><th>Jumlah Biaya</th></tr></thead>
        <tbody>
            <?php foreach($rows as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['NomorPesanan']); ?></td>
                <td><?= htmlspecialchars($r['JenisProduk']); ?></td>
                <td><?= htmlspecialchars($r['JmlPesanan']); ?></td>
                <td><?= htmlspecialchars($r['Kelompok']); ?></td>
                <td class="text-end"><?= number_format($r['JumlahBiaya']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between mt-3">
    <a href="laporan_e.php" class="btn btn-secondary">← Previous</a>
    <a href="laporan_g.php" class="btn btn-primary">Next →</a>
    </div>
</div>
</body>
</html>