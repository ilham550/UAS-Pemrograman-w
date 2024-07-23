<?php
session_start();
if(isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Halaman Registrasi</h1>
    <p>Silahkan isi form berikut!</p>
    <form action="" method="POST">
        <table>
            <tr>
                <td><label for="username">Username</label></td>
                <td><input type="text" name="username" id="username" required></td>
            </tr>
            <tr>
                <td><label for="password">Kata Sandi</label></td>
                <td><input type="password" name="password" id="password" required></td>
            </tr>
            <tr>
                <td><label for="confirm-password">Konfirmasi Kata Sandi</label></td>
                <td><input type="password" name="confirmpassword" id="confirm-password" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="register">Registrasi</button>
                    <button type="button" onClick="document.location.href='index.php'">Batal</button>
                </td>
            <tr>
                <td></td>
                <td>Sudah punya akun? <a href="login.php"><b>Login di sini!</b></a></td>
            </tr>
            </tr>
        </table>
    </form>

    <?php

    require('koneksi.php');

    if (isset($_POST["register"])) {
        $username = strtolower(stripslashes($_POST["username"]));
        $password = mysqli_real_escape_string($koneksi, $_POST["password"]);
        $confirm = mysqli_real_escape_string($koneksi, $_POST["confirmpassword"]);

        $hasilCek = mysqli_query($koneksi, "SELECT username FROM tbl_user WHERE username = '$username'");
        if (mysqli_fetch_assoc($hasilCek)) {
            echo "<script>
                    alert('Username sudah terdaftar');
                  </script>";
            exit;
        }

        if ($password !== $confirm) {
            echo "<script>
                    alert('Konfirmasi Kata Sandi tidak sesuai');
                  </script>";
            exit;
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $tambahAkun = "INSERT INTO tbl_user (username, password) VALUES ('$username', '$password')";
        mysqli_query($koneksi, $tambahAkun);
        $hasilTambahAkun = mysqli_affected_rows($koneksi);
        if ($hasilTambahAkun > 0) {
            echo "<script>
                    alert('Akun berhasil didaftarkan');
                    document.location.href = 'login.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Pendaftaran akun gagal');
                  </script>";
        }
    }
    ?>
</body>
</html>