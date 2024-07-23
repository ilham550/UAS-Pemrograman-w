<?php
session_start();
?>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang di Universitas Hamzanwadi</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <?php
        if (isset($_SESSION['username'])) {
            echo "<p>Selamat datang, " . htmlspecialchars($_SESSION['username']) . "! Anda sudah login.</p>";
        }
        ?>
        <nav>
            <ul>
                <li><a href="user.php" style="color: black; text-decoration: none;">user</a></li>
                <li><a href="ubah-pass.php" style="color: black; text-decoration: none;">ubah password</a></li>
                <li><a href="logout.php" style="color: black; text-decoration: none;" onclick="return confirm('Yakin log out?')">Log Out</a></li>
            </ul>
        </nav>
    </header>
    <div class="hero">
        <div>
            <h1>Selamat Datang di Universitas Hamzanwadi</h1>
            <p>Mencetak Generasi Unggul dan Berprestasi</p>
            <div style="text-align: center;">
                <button onclick="window.location.href='<?php echo isset($_SESSION['username']) ? 'tampilkan-data.php' : 'login.php'; ?>'">Lihat Data Mahasiswa</button>
            </div>
        </div>
    </div>
    <div class="content" style="position: absolute; bottom: 0; width: 100%;">
        <h2>Tentang Kami</h2>
        <p>Universitas Hamzanwadi adalah institusi pendidikan tinggi yang berkomitmen untuk mencetak generasi unggul dan berprestasi. Kami menawarkan berbagai program studi yang berkualitas dan didukung oleh tenaga pengajar yang profesional.</p>
    </div>
</body>
</html>