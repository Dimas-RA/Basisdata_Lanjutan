<?php
include "db.php";
$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM KartuPesanan WHERE NomorPesanan = ?";
    $stmt = $cnn->prepare($sql);
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
?>
