<?php
require_once __DIR__ . '/../db.php';
$sql = "SELECT SubKelompok, SUM(Jumlah) AS JumlahBiaya, COUNT(Jumlah) AS JmlPesanan, AVG(Jumlah) AS Rata_Rata, MAX(Jumlah) AS MaxBiaya, MIN(Jumlah) AS MinBiaya
FROM KartuPesanan A
INNER JOIN RincianBiaya B ON A.NomorPesanan = B.NomorPesanan
GROUP BY SubKelompok
ORDER BY SubKelompok";
$rows = $cnn->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan E</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3>e. Statistik Total Biaya per SubKelompok</h3>
    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark"><tr><th>SubKelompok</th><th>Jumlah Biaya</th><th>Jml Pesanan</th><th>Rata-rata</th><th>Max</th><th>Min</th></tr></thead>
        <tbody>
            <?php foreach($rows as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['SubKelompok']); ?></td>
                <td class="text-end"><?= number_format($r['JumlahBiaya']); ?></td>
                <td class="text-end"><?= number_format($r['JmlPesanan']); ?></td>
                <td class="text-end"><?= number_format($r['Rata_Rata'],2); ?></td>
                <td class="text-end"><?= number_format($r['MaxBiaya']); ?></td>
                <td class="text-end"><?= number_format($r['MinBiaya']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between mt-3">
    <a href="laporan_d.php" class="btn btn-secondary">← Previous</a>
    <a href="laporan_f.php" class="btn btn-primary">Next →</a>
    </div>
</div>
</body>
</html>