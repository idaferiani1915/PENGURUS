<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    die("Akses ditolak.");
}

require '../api/koneksi.php';
require '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$filter_jenis = $_GET['jenis_target'] ?? '';
$where = [];
if ($filter_jenis) {
    $where[] = "k.jenis_target = '" . $conn->real_escape_string($filter_jenis) . "'";
}

$where_clause = count($where) > 0 ? "WHERE " . implode(' AND ', $where) : "";

$query = "
    SELECT 
        k.id, k.jenis_target, k.divisi_target, k.isi_kritik, k.isi_saran, k.tanggal_masuk,
        p.nama, p.jabatan 
    FROM tbl_kritik_saran k
    LEFT JOIN tbl_pengurus p ON k.id_pengurus = p.id
    $where_clause
    ORDER BY k.tanggal_masuk DESC
";
$result = $conn->query($query);

$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Laporan Kritik & Saran - UKM Intermedia</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Target</th>
                <th>Kritik</th>
                <th>Saran</th>
            </tr>
        </thead>
        <tbody>';

$no = 1;
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $target = $row['jenis_target'] === 'Pengurus' 
            ? "Pengurus: " . $row['nama'] . " (" . $row['jabatan'] . " - " . $row['divisi_target'] . ")" 
            : "Divisi: " . $row['divisi_target'];
            
        $html .= '<tr>
            <td>'.$no++.'</td>
            <td>'.date('d/m/Y H:i', strtotime($row['tanggal_masuk'])).'</td>
            <td>'.$target.'</td>
            <td>'.nl2br(htmlspecialchars($row['isi_kritik'])).'</td>
            <td>'.nl2br(htmlspecialchars($row['isi_saran'])).'</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="5" style="text-align:center;">Tidak ada data</td></tr>';
}

$html .= '</tbody></table></body></html>';

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$dompdf = new Dompdf($options);
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("Laporan_Kritik_Saran.pdf", ["Attachment" => true]);
?>
