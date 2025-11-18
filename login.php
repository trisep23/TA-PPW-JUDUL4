<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['username'] == "trisep" && $_POST['password'] == "trisep") {

        $_SESSION['logged_in'] = true;

        if (!isset($_SESSION['kontak'])) {
            $_SESSION['kontak'] = [];
        }

        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - KontakKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class='bg-gradient-to-br from-gray-900 via-indigo-900 to-purple-900 min-h-screen flex justify-center items-center'>
<div class='bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl'>
    <h2 class='text-3xl font-bold text-center mb-2 pt-8'>KontakKu</h2>
    <p class='text-center text-gray-500 mb-8'>Login untuk mengelola kontak Anda</p>

    <?php if (isset($error)) { echo "<p class='text-red-500 text-center'>$error</p>"; } ?>

    <form method='POST'>
        <label class='block mb-2'>Username</label>
        <input name='username' value='trisep' required class='w-full px-4 py-3 border rounded-lg mb-4'>

        <label class='block mb-2'>Password</label>
        <input type='password' name='password' value='trisep' required class='w-full px-4 py-3 border rounded-lg mb-6'>

        <button class='w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg'>
            Login
        </button>
    </form>
</div>
</body>
</html>
