<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_SESSION['kontak'][$_GET['id']])) {
    $_SESSION['notif'] = "Kontak tidak ditemukan.";
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$nama = $_SESSION['kontak'][$id]['nama'];

if (isset($_GET['konfirmasi']) && $_GET['konfirmasi'] == 'ya') {

    unset($_SESSION['kontak'][$id]);

    $_SESSION['notif'] = "Kontak '$nama' berhasil dihapus.";
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Konfirmasi Hapus</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-gradient-to-r from-gray-900 via-indigo-900 to-purple-900 text-white shadow-lg w-full">
    <div class="px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Brand -->
            <div class="flex items-center">
                <span class="text-xl font-bold">KontakKu</span>
            </div>

            <!-- Menu -->
            <div class="flex items-center space-x-4">
                <a href="index.php" class="bg-white bg-opacity-10 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-opacity-20 transition">
                    Daftar Kontak
                </a>

                <a href="tambah_kontak.php" class="text-gray-200 hover:bg-white hover:bg-opacity-10 px-4 py-2 rounded-md text-sm font-medium transition">
                    Tambah Kontak
                </a>

                <a href="logout.php" class="bg-red-500 text-white py-2 px-4 rounded-lg text-sm font-semibold hover:bg-red-600 transition">
                    Logout
                </a>
            </div>

        </div>
    </div>
</nav>

<div class="container mx-auto max-w-lg px-4 py-8">
<div class="bg-white p-8 rounded-2xl shadow-lg">

<h2 class="text-2xl font-bold mb-4">Konfirmasi Hapus</h2>

<p class="mb-6">
Apakah Anda yakin ingin menghapus kontak
<strong class="text-red-600"><?= htmlspecialchars($nama) ?></strong>?
</p>

<div class="flex justify-end gap-3">
    <a href="index.php" class="bg-gray-200 px-4 py-2 rounded">Batal</a>
    <a href="konfirmasi_hapus.php?id=<?= $id ?>&konfirmasi=ya"
       class="bg-red-600 text-white px-4 py-2 rounded">Ya, Hapus</a>
</div>

</div>
</div>

</body>
</html>
