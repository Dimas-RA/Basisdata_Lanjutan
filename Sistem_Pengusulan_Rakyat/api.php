<?php
header('Content-Type: application/json');

// 1. Konfigurasi Database
$host = 'localhost';
$db   = 'pengusulan_rakyat';
$user = 'root'; // Ganti dengan user DB Anda
$pass = '';     // Ganti dengan password DB Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(["success" => false, "message" => "Koneksi DB Gagal: " . $e->getMessage()]));
}

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

// Logika Routing
switch ($action) {
    case 'create':
        if ($method == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            
            // Panggil Stored Procedure
            $sql = "CALL SP_Tambah_Usulan(?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                $data->nama_pengusul, 
                $data->email_pengusul ?? null, 
                $data->topik_usulan, 
                $data->deskripsi_usulan
            ]);
            
            echo json_encode(["success" => true, "message" => "Usulan berhasil ditambahkan (via Stored Procedure)."]);
        }
        break;
        
    case 'read':
    $sql = "SELECT id_usulan, nama_pengusul, topik_usulan, tanggal_pengusulan, status_usulan FROM usulan"; 
    
    if (isset($_GET['search']) && $_GET['search'] != '') {
        $searchTerm = '%' . $_GET['search'] . '%';
        // Tambahkan status_usulan ke kolom yang ditampilkan
        $sql .= " WHERE nama_pengusul LIKE ? OR topik_usulan LIKE ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm]);
    } else {
        $stmt = $pdo->query($sql);
    }
    
    $usulan = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(["success" => true, "data" => $usulan]);
    break;

    case 'update':
        // Logika UPDATE sederhana (menggunakan UPDATE biasa, yang akan memicu TRIGGER)
        if ($method == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            $sql = "UPDATE usulan SET status_usulan = ? WHERE id_usulan = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->status_usulan, $data->id_usulan]);

            echo json_encode(["success" => true, "message" => "Status usulan diupdate."]);
        }
        break;
        
    case 'delete':
        if ($method == 'POST') {
            $data = json_decode(file_get_contents("php://input"));
            $sql = "DELETE FROM usulan WHERE id_usulan = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$data->id_usulan]);
            
            echo json_encode(["success" => true, "message" => "Usulan berhasil dihapus."]);
        }
        break;
        
    default:
        http_response_code(400);
        echo json_encode(["success" => false, "message" => "Aksi tidak dikenal."]);
}
?>