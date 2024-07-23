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
    <title>Ubah Data Mahasiswa</title>
</head>
<body>
    <h1>Ubah Data Mahasiswa</h1>
    <h2>Universitas Hamzanwadi</h2>
    <p>Silahkan ubah data mahasiswa:</p>

    <?php
    // Memulai sesi

    // Melakukan koneksi ke DB dengan menyisipkan file koneksi.php
    require("koneksi.php");

    // Ambil data idMhs yang dikirim melalui URL dengan metode GET
    $idMhs = $_GET["idMhs"];

    // Ambil data mahasiswa dengan filter idMhs untuk menampilkan data yang akan diubah
    $dataUbah = "SELECT * FROM tbl_mahasiswa WHERE idMhs = $idMhs";
    $lihatUbah = mysqli_query($koneksi, $dataUbah);
    $data = mysqli_fetch_assoc($lihatUbah);
    ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <table style="width: 80%; padding: 10px;">
            <tr>
                <td style="width: 10%;"><label for="nama">Nama</label></td>
                <td><input type="text" name="nama" id="nama" value="<?= htmlspecialchars($data['nama']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="npm">NPM</label></td>
                <td><input type="text" name="npm" id="npm" value="<?= htmlspecialchars($data['npm']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="prodi">Program Studi</label></td>
                <td>
                    <select name="prodi" id="prodi" required>
                        <option value="Pendidikan Informatika" <?php if($data['prodi'] == "Pendidikan Informatika") echo "selected"; ?>>Pendidikan Informatika</option>
                        <option value="Pendidikan Matematika" <?php if($data['prodi'] == "Pendidikan Matematika") echo "selected"; ?>>Pendidikan Matematika</option>
                        <option value="Pendidikan Biologi" <?php if($data['prodi'] == "Pendidikan Biologi") echo "selected"; ?>>Pendidikan Biologi</option>
                        <option value="Pendidikan Fisika" <?php if($data['prodi'] == "Pendidikan Fisika") echo "selected"; ?>>Pendidikan Fisika</option>
                        <option value="Pendidikan IPA" <?php if($data['prodi'] == "Pendidikan IPA") echo "selected"; ?>>Pendidikan IPA</option>
                        <option value="Statistika" <?php if($data['prodi'] == "Statistika") echo "selected"; ?>>Statistika</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td><input type="email" name="email" id="email" value="<?= htmlspecialchars($data['email']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="alamat">Alamat</label></td>
                <td><input type="text" name="alamat" id="alamat" value="<?= htmlspecialchars($data['alamat']); ?>" required></td>
            </tr>
            <tr>
                <td><label for="photo">Photo</label></td>
                <td><input type="file" name="photo" id="photo" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit" name="submit">Ubah Data</button>
                    <button type="button" onClick="document.location.href='index.php'">Batal</button>
                </td>
            </tr>
        </table>
        <p>Apabila ingin mengubah data maka Foto juga perlu diubah</p>
    </form>

    <?php
    // Menangkap data yang dimasukkan saat menekan button submit, kemudian disimpan dalam variabel
    if (isset($_POST["submit"])) {
        // Data yg disubmit disimpan dalam variabel dan di-escape untuk mencegah SQL Injection
        $npm = mysqli_real_escape_string($koneksi, $_POST["npm"]);
        $nama = mysqli_real_escape_string($koneksi, $_POST["nama"]);
        $prodi = mysqli_real_escape_string($koneksi, $_POST["prodi"]);
        $email = mysqli_real_escape_string($koneksi, $_POST["email"]);
        $alamat = mysqli_real_escape_string($koneksi, $_POST["alamat"]);

        // Mengunggah file photo
        $photo = $_FILES['photo']['name'];
        $tmp_name = $_FILES['photo']['tmp_name'];
        $photo_folder = "uploads/" . basename($photo);

        // Check if the uploads directory exists, create it if not
        if (!file_exists("uploads")) {
            mkdir("uploads");
        }

        if (move_uploaded_file($tmp_name, $photo_folder)) {
            // Mengubah data dari PHP ke MySQL
            $ubahData = "UPDATE tbl_mahasiswa SET
                            npm = '$npm',
                            nama = '$nama',
                            prodi = '$prodi',
                            email = '$email',
                            alamat = '$alamat',
                            Foto = '$photo'
                         WHERE idMhs = $idMhs";

            mysqli_query($koneksi, $ubahData);

            $hasilUbah = mysqli_affected_rows($koneksi);

            // Mengecek apakah data terkirim
            if ($hasilUbah > 0) {
                echo "<script>
                        alert('Data Berhasil diubah');
                        document.location.href = 'tampilkan-data.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Data Gagal diubah');
                        document.location.href = 'tampilkan-data.php';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Gagal mengunggah photo');
                  </script>";
        }
    }
    ?>
</body>
</html>