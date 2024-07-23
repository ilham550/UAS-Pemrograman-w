<?php
session_start();
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}

// cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// menyisipkan file koneksi.php
require('koneksi.php');

// mengambil data user dari database
$username = $_SESSION['username'];
$stmt = $koneksi->prepare("SELECT * FROM tbl_user WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Pengguna</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php" style="color: black; text-decoration: none;">Beranda</a></li>
            </ul>
        </nav>
    </header>
    <div class="profile">
        <h1>Profil Pengguna</h1>
        <p>Username: <?php echo htmlspecialchars($user['username']); ?></p>
        <p>Password: <?php echo "********"; ?></p>
    </div>
</body>
</html>