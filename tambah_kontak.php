<?php
session_start();

// Jika belum login, tendang ke login
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

$errors = [];

// Jika form disubmit
if (isset($_POST['simpan'])) {

    $nama   = trim($_POST['nama_kontak']);
    $telp   = trim($_POST['telepon']);
    $email  = trim($_POST['email']);
    $alamat = trim($_POST['alamat']);

    // Validasi server-side (PHP)
    if (empty($nama))  $errors['nama'] = "Nama wajib diisi.";
    if (empty($telp))  $errors['telp'] = "Nomor telepon wajib diisi.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
        $errors['email'] = "Format email tidak valid (harus ada @).";
    if (empty($alamat)) $errors['alamat'] = "Alamat wajib diisi.";

    // Jika tidak ada error
    if (empty($errors)) {

        $_SESSION['kontak'][] = [
            "nama" => $nama,
            "telp" => $telp,
            "email" => $email,
            "alamat" => $alamat
        ];

        $_SESSION['notif'] = "Kontak '$nama' berhasil ditambahkan!";
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Tambah Kontak - KontakKu</title>
<script src="https://cdn.tailwindcss.com"></script>
<style> body { font-family: 'Inter', sans-serif; } </style>
</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-gradient-to-r from-gray-900 via-indigo-900 to-purple-900 text-white shadow-lg w-full">
    <div class="px-8">
        <div class="flex justify-between items-center h-16">

            <span class="text-xl font-bold">KontakKu</span>

            <div class="flex items-center space-x-4">
                <a href="index.php" class="bg-white bg-opacity-10 text-white px-4 py-2 rounded-md text-sm hover:bg-opacity-20 transition">
                    Daftar Kontak
                </a>

                <a href="tambah_kontak.php" class="text-gray-200 hover:bg-white hover:bg-opacity-10 px-4 py-2 rounded-md text-sm transition">
                    Tambah Kontak
                </a>

                <a href="logout.php" class="bg-red-500 text-white py-2 px-4 rounded-lg text-sm font-semibold hover:bg-red-600 transition">
                    Logout
                </a>
            </div>

        </div>
    </div>
</nav>

<!-- FORM TAMBAH -->
<div class="container mx-auto max-w-lg px-4 py-10">
<div class="bg-white p-8 rounded-2xl shadow-lg">

<h2 class="text-2xl font-bold mb-6">Tambah Kontak Baru</h2>

<form method="POST">

    <!-- NAMA -->
    <label class="font-medium">Nama Kontak</label>
    <input 
        name="nama_kontak"
        class="w-full px-4 py-2 border rounded mb-1 <?= isset($errors['nama']) ? 'border-red-500' : 'border-gray-300'; ?>"
        value="<?= $_POST['nama_kontak'] ?? ''; ?>"
        required
    >
    <?php if (isset($errors['nama'])): ?>
        <p class="text-red-600 text-sm mb-3"><?= $errors['nama']; ?></p>
    <?php else: ?><div class="mb-3"></div><?php endif; ?>

    <!-- TELEPON -->
    <label class="font-medium">No Telepon</label>
    <input 
        name="telepon"
        class="w-full px-4 py-2 border rounded mb-1 <?= isset($errors['telp']) ? 'border-red-500' : 'border-gray-300'; ?>"
        value="<?= $_POST['telepon'] ?? ''; ?>"
        required
    >
    <?php if (isset($errors['telp'])): ?>
        <p class="text-red-600 text-sm mb-3"><?= $errors['telp']; ?></p>
    <?php else: ?><div class="mb-3"></div><?php endif; ?>

    <!-- EMAIL -->
    <label class="font-medium">Email</label>
    <input 
        type="email"
        name="email"
        required
        pattern="[^@\s]+@[^@\s]+\.[^@\s]+"
        title="Format email harus benar, contoh: nama@example.com"
        class="w-full px-4 py-2 border rounded mb-1 <?= isset($errors['email']) ? 'border-red-500' : 'border-gray-300'; ?>"
        value="<?= $_POST['email'] ?? ''; ?>"
    >
    <?php if (isset($errors['email'])): ?>
        <p class="text-red-600 text-sm mb-3"><?= $errors['email']; ?></p>
    <?php else: ?><div class="mb-3"></div><?php endif; ?>

    <!-- ALAMAT -->
    <label class="font-medium">Alamat</label>
    <textarea
        name="alamat"
        required
        class="w-full px-4 py-2 border rounded mb-1 <?= isset($errors['alamat']) ? 'border-red-500' : 'border-gray-300'; ?>"
        rows="3"
    ><?= $_POST['alamat'] ?? ''; ?></textarea>
    <?php if (isset($errors['alamat'])): ?>
        <p class="text-red-600 text-sm mb-3"><?= $errors['alamat']; ?></p>
    <?php else: ?><div class="mb-5"></div><?php endif; ?>

    <!-- BUTTON -->
    <div class="flex justify-end gap-3 mt-4">
        <a href="index.php" class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 transition">Batal</a>

        <button 
            name="simpan"
            class="bg-indigo-600 text-white px-5 py-2 rounded hover:bg-indigo-700 transition"
        >Simpan</button>
    </div>

</form>

</div>
</div>

</body>
</html>
