<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    die("Akses ditolak.");
}

require '../api/koneksi.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Kritik & Saran');

// Header
$sheet->setCellValue('A1', 'No');
$sheet->setCellValue('B1', 'Tanggal');
$sheet->setCellValue('C1', 'Jenis Target');
$sheet->setCellValue('D1', 'Nama Pengurus / Divisi');
$sheet->setCellValue('E1', 'Kritik');
$sheet->setCellValue('F1', 'Saran');

// Bold header
$sheet->getStyle('A1:F1')->getFont()->setBold(true);

$rowNum = 2;
$no = 1;

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $target_name = $row['jenis_target'] === 'Pengurus' ? $row['nama'] . " (" . $row['jabatan'] . " - " . $row['divisi_target'] . ")" : $row['divisi_target'];
        
        $sheet->setCellValue('A'.$rowNum, $no++);
        $sheet->setCellValue('B'.$rowNum, date('d/m/Y H:i', strtotime($row['tanggal_masuk'])));
        $sheet->setCellValue('C'.$rowNum, $row['jenis_target']);
        $sheet->setCellValue('D'.$rowNum, $target_name);
        $sheet->setCellValue('E'.$rowNum, $row['isi_kritik']);
        $sheet->setCellValue('F'.$rowNum, $row['isi_saran']);
        $rowNum++;
    }
}

// Auto size columns
foreach(range('A','F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Laporan_Kritik_Saran.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
