<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_SESSION['kontak'])) {
    $_SESSION['kontak'] = [];
}

$kontak_list = $_SESSION['kontak'];

$search_term = "";
if (isset($_GET['search_nama']) && !empty($_GET['search_nama'])) {
    $search_term = strtolower(trim($_GET['search_nama']));

    $filtered = [];
    foreach ($kontak_list as $i => $k) {
        if (strpos(strtolower($k['nama']), $search_term) !== false) {
            $filtered[$i] = $k;
        }
    }
    $kontak_list = $filtered;
}

$notif = "";
if (isset($_SESSION['notif'])) {
    $notif = $_SESSION['notif'];
    unset($_SESSION['notif']);
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>KontakKu - Daftar Kontak</title>
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

<div class="container mx-auto px-4 py-8 max-w-5xl">
<div class="bg-white p-6 rounded-2xl shadow-lg">

<h2 class="text-3xl font-bold mb-6">Daftar Kontak Anda</h2>

<?php if (!empty($notif)): ?>
<div class="p-3 bg-green-100 text-green-700 rounded mb-4"><?= $notif ?></div>
<?php endif; ?>

<form method="GET" class="flex gap-3 mb-6">
    <input type="text" name="search_nama" placeholder="Cari nama..." 
           value="<?= htmlspecialchars($search_term) ?>"
           class="flex-grow border px-4 py-2 rounded-lg">
    <button class="bg-indigo-600 text-white px-5 py-2 rounded-lg">Cari</button>
</form>

<table class="w-full text-left">
<thead>
<tr class="bg-gray-50 border-b">
    <th class="px-4 py-3">Nama</th>
    <th class="px-4 py-3">Telepon</th>
    <th class="px-4 py-3">Email</th>
    <th class="px-4 py-3">Alamat</th>
    <th class="px-4 py-3 text-center">Aksi</th>
</tr>
</thead>
<tbody class="divide-y">

<?php if (empty($kontak_list)): ?>
<tr><td colspan="5" class="text-center py-4 text-gray-500">Belum ada kontak.</td></tr>
<?php else: ?>

<?php foreach ($kontak_list as $id => $k): ?>
<tr>

    <td class="px-4 py-3 align-middle">
        <?= htmlspecialchars($k['nama']) ?>
    </td>

    <td class="px-4 py-3 align-middle">
        <?= htmlspecialchars($k['telp']) ?>
    </td>

    <td class="px-4 py-3 align-middle">
        <?= htmlspecialchars($k['email']) ?>
    </td>

    <td class="px-4 py-3 align-middle">
        <?= htmlspecialchars($k['alamat']) ?>
    </td>

    <td class="px-4 py-3 text-center align-middle">
        <a href="edit_kontak.php?id=<?= $id ?>" 
           class="bg-yellow-400 px-3 py-1 rounded-lg text-yellow-900">Edit</a>
        <a href="konfirmasi_hapus.php?id=<?= $id ?>" 
           class="bg-red-500 text-white px-3 py-1 rounded-lg">Hapus</a>
    </td>

</tr>
<?php endforeach; ?>

<?php endif; ?>

</tbody>
</table>

</div>
</div>

</body>
</html>