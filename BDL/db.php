<?php
$dsn = "mysql:host=localhost;dbname=db_perusahaan;charset=utf8mb4";
$user = "root";
$pass = "";

try {
    $cnn = new PDO($dsn, $user, $pass);
    $cnn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
