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
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Halaman Login</h1>
    <p>Silahkan masukkan username dan password</p>

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
                <td></td>
                <td><button type="submit" name="login">Login</button></td>
            </tr>
            <tr>
                <td></td>
                <td>Belum punya akun?<a href="register.php"> <b>Daftar sini!</b></a></td>
            </tr>
        </table>
    </form>

    <?php
    require('koneksi.php');

    if(isset($_POST["login"])){
        $stmt = $koneksi->prepare("SELECT * FROM tbl_user WHERE username = ?");
        $stmt->bind_param("s", $_POST["username"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 1){
            $user = $result->fetch_assoc();
            // cek password
            if(password_verify($_POST["password"], $user["password"])){
                // set session
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; 
                $_SESSION['login'] = true; 
                

                $session_query = "INSERT INTO tbl_session (username, role) VALUES ('{$user['username']}', '{$user['role']}')";
                mysqli_query($koneksi, $session_query);

                header("Location: index.php");
                exit;
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }

        if(isset($error)){
            echo "<script>alert('Maaf.... username/password yang anda masukkan salah');</script>";
        }

        $stmt->close();
    }

    $koneksi->close();
    ?>
</body>
</html>