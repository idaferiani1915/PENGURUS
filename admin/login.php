<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username === 'admin' && $password === 'intermedia') {
        $_SESSION['admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="ASSETS/favicon.ico">
</head>
<body class="bg-slate-900 h-screen flex items-center justify-center">
    <div class="bg-slate-800 p-8 rounded-2xl shadow-xl max-w-sm w-full border border-slate-700">
        <h2 class="text-2xl font-bold text-white text-center mb-6">Login Admin</h2>
        <?php if ($error): ?>
            <div class="bg-red-500/20 text-red-400 p-3 rounded-lg mb-4 text-sm text-center"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm text-slate-300 mb-1">Username</label>
                <input type="text" name="username" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <div>
                <label class="block text-sm text-slate-300 mb-1">Password</label>
                <input type="password" name="password" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 outline-none" required>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-medium py-2 rounded-lg transition mt-4">Login</button>
        </form>
    </div>
</body>
</html>
