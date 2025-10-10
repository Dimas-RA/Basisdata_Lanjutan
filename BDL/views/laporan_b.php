<?php
require_once __DIR__ . '/../db.php';
$sql = "SELECT YEAR(B.Tanggal) AS Tahun, MONTH(B.Tanggal) AS Bulan, Kelompok, SUM(Jumlah) AS JumlahBiaya
FROM KartuPesanan A
INNER JOIN RincianBiaya B ON A.NomorPesanan = B.NomorPesanan
GROUP BY YEAR(B.Tanggal), MONTH(B.Tanggal), Kelompok
ORDER BY 1,2,3";
$rows = $cnn->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Laporan B</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h3>b. Laporan Biaya Langsung per Bulan</h3>
    <table class="table table-striped table-bordered mt-3">
        <thead class="table-dark">
            <tr><th>Tahun</th><th>Bulan</th><th>Kelompok</th><th>Jumlah Biaya</th></tr>
        </thead>
        <tbody>
            <?php foreach($rows as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r['Tahun']); ?></td>
                <td><?= htmlspecialchars($r['Bulan']); ?></td>
                <td><?= htmlspecialchars($r['Kelompok']); ?></td>
                <td class="text-end"><?= number_format($r['JumlahBiaya']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between mt-3">
    <a href="laporan_a.php" class="btn btn-secondary">← Previous</a>
    <a href="laporan_c.php" class="btn btn-primary">Next →</a>
    </div>
</div>
</body>
</html>