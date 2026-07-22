<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

require '../api/koneksi.php';

// Filter
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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="ASSETS/favicon.ico">
</head>
<body class="bg-slate-100 min-h-screen">
    <nav class="bg-slate-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <h1 class="font-bold text-xl">Admin Panel - Intermedia</h1>
            <a href="?logout=1" class="text-sm bg-red-600 hover:bg-red-500 px-4 py-2 rounded-lg transition">Logout</a>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8 flex justify-between items-center border border-slate-200">
            <form class="flex gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Filter Jenis Target</label>
                    <select name="jenis_target" class="border border-slate-300 rounded-lg px-4 py-2 bg-slate-50 outline-none focus:border-blue-500">
                        <option value="">Semua</option>
                        <option value="Pengurus" <?php echo $filter_jenis === 'Pengurus' ? 'selected' : ''; ?>>Pengurus</option>
                        <option value="Divisi" <?php echo $filter_jenis === 'Divisi' ? 'selected' : ''; ?>>Divisi</option>
                    </select>
                </div>
                <button type="submit" class="bg-slate-800 text-white px-6 py-2 rounded-lg hover:bg-slate-700 transition">Filter</button>
            </form>
            <div class="flex gap-3">
                <a href="export_pdf.php?jenis_target=<?php echo urlencode($filter_jenis); ?>" class="bg-red-600 hover:bg-red-500 text-white px-4 py-2 rounded-lg transition text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export PDF
                </a>
                <a href="export_excel.php?jenis_target=<?php echo urlencode($filter_jenis); ?>" class="bg-green-600 hover:bg-green-500 text-white px-4 py-2 rounded-lg transition text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Excel
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-sm">
                            <th class="py-3 px-4 font-medium">Tanggal</th>
                            <th class="py-3 px-4 font-medium">Target</th>
                            <th class="py-3 px-4 font-medium w-1/3">Kritik</th>
                            <th class="py-3 px-4 font-medium w-1/3">Saran</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm divide-y divide-slate-200">
                        <?php if ($result && $result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="py-3 px-4 text-slate-500 whitespace-nowrap"><?php echo date('d/m/Y H:i', strtotime($row['tanggal_masuk'])); ?></td>
                                    <td class="py-3 px-4">
                                        <?php if ($row['jenis_target'] === 'Pengurus'): ?>
                                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-md mb-1 font-medium">Individu</span><br>
                                            <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($row['nama']); ?></span><br>
                                            <span class="text-slate-500 text-xs"><?php echo htmlspecialchars($row['jabatan']); ?> (<?php echo htmlspecialchars($row['divisi_target']); ?>)</span>
                                        <?php else: ?>
                                            <span class="inline-block px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-md mb-1 font-medium">Divisi</span><br>
                                            <span class="font-semibold text-slate-800"><?php echo htmlspecialchars($row['divisi_target']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-3 px-4 text-slate-700"><?php echo nl2br(htmlspecialchars($row['isi_kritik'] ?: '-')); ?></td>
                                    <td class="py-3 px-4 text-slate-700"><?php echo nl2br(htmlspecialchars($row['isi_saran'] ?: '-')); ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="py-8 text-center text-slate-500">Belum ada data kritik & saran.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
