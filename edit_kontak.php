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
$kontak = $_SESSION['kontak'][$id];

$errors = [];

if (isset($_POST['update'])) {

    $nama = trim($_POST['nama_kontak']);
    $telp = trim($_POST['telepon']);
    $email = trim($_POST['email']);
    $alamat = trim($_POST['alamat']);

    if (empty($nama)) $errors['nama'] = "Nama wajib diisi.";
    if (empty($telp)) $errors['telp'] = "Telepon wajib diisi.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Email tidak valid.";
    if (empty($alamat)) $errors['alamat'] = "Alamat wajib diisi.";

    if (empty($errors)) {

        $_SESSION['kontak'][$id] = [
            "nama" => $nama,
            "telp" => $telp,
            "email" => $email,
            "alamat" => $alamat
        ];

        $_SESSION['notif'] = "Kontak berhasil diperbarui!";
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Kontak</title>
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

<h2 class="text-2xl font-bold mb-6">Edit Kontak</h2>

<form method="POST">

<label>Nama Kontak</label>
<input name="nama_kontak" value="<?= htmlspecialchars($kontak['nama']) ?>" class="w-full px-4 py-2 border rounded mb-3">

<label>No Telepon</label>
<input name="telepon" value="<?= htmlspecialchars($kontak['telp']) ?>" class="w-full px-4 py-2 border rounded mb-3">

<label>Email</label>
<input name="email" value="<?= htmlspecialchars($kontak['email']) ?>" class="w-full px-4 py-2 border rounded mb-3">

<label>Alamat</label>
<textarea name="alamat" class="w-full px-4 py-2 border rounded mb-5"><?= htmlspecialchars($kontak['alamat']) ?></textarea>

<div class="flex justify-end gap-3">
    <a href="index.php" class="bg-gray-200 px-4 py-2 rounded">Batal</a>
    <button name="update" class="bg-indigo-600 text-white px-4 py-2 rounded">Perbarui</button>
</div>

</form>

</div>
</div>

</body>
</html>
