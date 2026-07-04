<?php
header('Content-Type: application/json');
require 'koneksi.php';

$query = "SELECT id, nama, jabatan, divisi, foto FROM tbl_pengurus ORDER BY divisi, id";
$result = $conn->query($query);

$pengurus = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $divisi = $row['divisi'];
        if (!isset($pengurus[$divisi])) {
            $pengurus[$divisi] = [];
        }
        
        // Handle fallback avatar
        if (empty($row['foto'])) {
            $row['foto'] = 'ASSETS/foto/default-avatar.png';
        }
        
        $pengurus[$divisi][] = $row;
    }
}

echo json_encode($pengurus);
?>
