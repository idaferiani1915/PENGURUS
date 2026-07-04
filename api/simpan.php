<?php
session_start();
header('Content-Type: application/json');
require 'koneksi.php';

// Session Cooldown (1 submission per 30 seconds)
if (isset($_SESSION['last_submission_time'])) {
    $elapsed = time() - $_SESSION['last_submission_time'];
    if ($elapsed < 30) {
        echo json_encode(["status" => "gagal", "pesan" => "Mohon tunggu " . (30 - $elapsed) . " detik sebelum mengirim lagi."]);
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jenis_target = $_POST['jenis_target'] ?? '';
    $id_pengurus = $_POST['id_pengurus'] ?? null;
    $divisi_target = $_POST['divisi_target'] ?? '';
    $isi_kritik = trim($_POST['isi_kritik'] ?? '');
    $isi_saran = trim($_POST['isi_saran'] ?? '');

    if (empty($isi_kritik) && empty($isi_saran)) {
        echo json_encode(["status" => "gagal", "pesan" => "Kritik atau Saran harus diisi."]);
        exit;
    }

    if ($jenis_target === 'Pengurus') {
        if (empty($id_pengurus)) {
            echo json_encode(["status" => "gagal", "pesan" => "ID Pengurus tidak valid."]);
            exit;
        }

        // Validate id_pengurus and get divisi_target automatically
        $stmt_check = $conn->prepare("SELECT divisi FROM tbl_pengurus WHERE id = ?");
        $stmt_check->bind_param("i", $id_pengurus);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows === 0) {
            echo json_encode(["status" => "gagal", "pesan" => "Pengurus tidak ditemukan."]);
            exit;
        }

        $row = $result_check->fetch_assoc();
        $divisi_target = $row['divisi'];
        $stmt_check->close();

    } elseif ($jenis_target === 'Divisi') {
        $id_pengurus = null;
        $valid_divisi = ['PH', 'Kaderisasi', 'Humas', 'Ristek', 'Content Creator', 'Keilmuan', 'Programming', 'Multimedia', 'Sistem Robotika'];
        
        if (!in_array($divisi_target, $valid_divisi)) {
            echo json_encode(["status" => "gagal", "pesan" => "Divisi tidak valid."]);
            exit;
        }
    } else {
        echo json_encode(["status" => "gagal", "pesan" => "Jenis target tidak valid."]);
        exit;
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO tbl_kritik_saran (jenis_target, id_pengurus, divisi_target, isi_kritik, isi_saran) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sisss", $jenis_target, $id_pengurus, $divisi_target, $isi_kritik, $isi_saran);

    if ($stmt->execute()) {
        $_SESSION['last_submission_time'] = time();
        echo json_encode(["status" => "sukses", "pesan" => "Berhasil disimpan."]);
    } else {
        echo json_encode(["status" => "gagal", "pesan" => "Gagal menyimpan data."]);
    }
    
    $stmt->close();
}
?>
