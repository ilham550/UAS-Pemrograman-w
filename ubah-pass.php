<?php
session_start();
if(!isset($_SESSION["login"])){
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

if (isset($_POST["ubah"])) {
    $passwordLama = mysqli_real_escape_string($koneksi, $_POST["passwordLama"]);
    $passwordBaru = mysqli_real_escape_string($koneksi, $_POST["passwordBaru"]);
    $konfirmasiPassword = mysqli_real_escape_string($koneksi, $_POST["konfirmasiPassword"]);

    // cek kesesuaian password lama
    if (!password_verify($passwordLama, $user["password"])) {
        echo "<script>
                alert('Password lama tidak sesuai');
              </script>";
    } elseif ($passwordBaru !== $konfirmasiPassword) {
        echo "<script>
                alert('Konfirmasi password baru tidak sesuai');
              </script>";
    } else {
        // enkripsi password baru
        $passwordBaru = password_hash($passwordBaru, PASSWORD_DEFAULT);

        // update password di database
        $stmt = $koneksi->prepare("UPDATE tbl_user SET password = ? WHERE username = ?");
        $stmt->bind_param("ss", $passwordBaru, $username);
        $stmt->execute();
        $stmt->close();

        echo "<script>
                alert('Password berhasil diubah');
                document.location.href = 'login.php';
              </script>";
    }
}

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ubah Password</title>
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
    <div class="ubah-password">
        <h1>Ubah Password</h1>
        <form action="" method="POST">
            <table>
                <tr>
                    <td><label for="passwordLama">Password Lama</label></td>
                    <td><input type="password" name="passwordLama" id="passwordLama" required></td>
                </tr>
                <tr>
                    <td><label for="passwordBaru">Password Baru</label></td>
                    <td><input type="password" name="passwordBaru" id="passwordBaru" required></td>
                </tr>
                <tr>
                    <td><label for="konfirmasiPassword">Konfirmasi Password Baru</label></td>
                    <td><input type="password" name="konfirmasiPassword" id="konfirmasiPassword" required></td>
                </tr>
                <tr>
                    <td></td>
                    <td><button type="submit" name="ubah">Ubah Password</button></td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>