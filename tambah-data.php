<?php
session_start();
if(!isset($_SESSION["login"])){
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>tambah kan data dengan mengisi biodata mahasiswa</h1>
    <h2 style="text-align: center;">Universitas Hamzanwadi</h2>
    <p>Silahkan masukkan data mahasiswa berdasarkan formulir berikut:</p>

    <form action="" method="POST" enctype="multipart/form-data">
        <table style="width: 80%; padding: 10px;">
            <tr>
                <td style="width: 10%;"><label for="nama">Nama</label></td>
                <td><input type="text" name="nama" id="nama"></td>
            </tr>
            <tr>
                <td><label for="npm">NPM</label></td>
                <td><input type="text" name="npm" id="npm"></td>
            </tr>
            <tr>
                <td><label for="prodi">Program Studi</label></td>
                <td>
                    <select name="prodi" id="prodi">
                        <option value="Pendidikan Informatika">Pendidikan Informatika</option>
                        <option value="Pendidikan Matematika">Pendidikan Matematika</option>
                        <option value="Pendidikan Biologi">Pendidikan Biologi</option>
                        <option value="Pendidikan Fisika">Pendidikan Fisika</option>
                        <option value="Pendidikan IPA">Pendidikan IPA</option>
                        <option value="Statistika">Statistika</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td><input type="email" name="email" id="email"></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat</label></td>
                <td><input type="text" name="alamat" id="alamat"></td>
            </tr>
            <tr>
                <td><label for="photo">Photo</label></td>
                <td><input type="file" name="photo" id="photo"></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="submit">Tambah Data</button>
                </td>
            </tr>
        </table>
    </form>

    <?php
    require("koneksi.php");

    if(isset($_POST["submit"])){
        $npm = mysqli_real_escape_string($koneksi, $_POST["npm"]);
        $nama = mysqli_real_escape_string($koneksi, $_POST["nama"]);
        $prodi = mysqli_real_escape_string($koneksi, $_POST["prodi"]);
        $email = mysqli_real_escape_string($koneksi, $_POST["email"]);
        $alamat = mysqli_real_escape_string($koneksi, $_POST["alamat"]);
        
        // Upload file
        $photo = $_FILES['photo']['name'];
        $tmp = $_FILES['photo']['tmp_name'];
        $path = "uploads/" . basename($photo);

        // Check if the uploads directory exists, create it if not
        if (!file_exists("uploads")) {
            mkdir("uploads");
        }
        
        if(!empty($photo)){
            if(move_uploaded_file($tmp, $path)){
                $kirim = "INSERT INTO tbl_mahasiswa (npm, nama, prodi, email, alamat, foto) VALUES ('$npm', '$nama', '$prodi', '$email', '$alamat', '$photo')";
            } else {
                echo "<script>
                alert('Gagal mengunggah foto');
                document.location.href = 'tampilkan-data.php';
                </script>";
                exit;
            }
        } else {
            $kirim = "INSERT INTO tbl_mahasiswa (npm, nama, prodi, email, alamat) VALUES ('$npm', '$nama', '$prodi', '$email', '$alamat')";
        }
        
        mysqli_query($koneksi, $kirim);
        
        $hasil = mysqli_affected_rows($koneksi);
        
        if($hasil){
            echo "<script>
            alert('Data Berhasil disimpan');
            document.location.href = 'tampilkan-data.php';
            </script>";
        } else {
            echo "<script>
            alert('Data Gagal disimpan');
            document.location.href = 'tampbah-data.php';
            </script>";
        }
    }
    ?>
</body>
</html>