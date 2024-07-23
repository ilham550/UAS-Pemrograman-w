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
    <title>Data Mahasiswa</title>
    <style>
        table, tr, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
        table {
            width: 80%;
            margin: auto;
        }
        th {
            background-color: green;
            color: yellow;
        }
    </style>
</head>
<body>
    <header>
        <header style="text-align: center;">
            <nav>
                <ul style="display: inline-block; list-style-type: none; padding: 0;">
                    <li style="display: inline; margin-right: 20px;"><a href="index.php" style="color: black; text-decoration: none;">Beranda</a></li>
                </ul>
            </nav>
        </header>
        
        </div>
    </header>
    <h1 style="text-align: center;">Daftar Mahasiswa</h1>
    <h2 style="text-align: center;">Universitas Hamzanwadi</h2>
    <p style="text-align: center;">Berikut daftar mahasiswa Universitas Hamzanwadi</p>
    
    <div style="text-align: center; margin-bottom: 20px;">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Cari Nama Mahasiswa" style="padding: 5px; width: 200px;">
            <button type="submit" style="background-color: green; color: white; border: none; padding: 5px 10px; cursor: pointer;">Cari</button>
        </form>
    </div>
    
    <table>
        <tr>
            <th>No</th>
            <th>NPM</th>
            <th>Nama</th>
            <th>Program Studi</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Foto</th>
            <th>Aksi</th>
        </tr>
        <?php
        require("koneksi.php");
        
        if (isset($_GET['search'])) {
            $search = mysqli_real_escape_string($koneksi, $_GET['search']);
            $dataTabel = "SELECT * FROM tbl_mahasiswa WHERE nama LIKE '%$search%'";
        } else {
            $dataTabel = "SELECT * FROM tbl_mahasiswa";
        }
        
        $dataTampil = mysqli_query($koneksi, $dataTabel);
        $urut = 1;
        while($data = mysqli_fetch_assoc($dataTampil)):
        ?>
        <tr>
            <td><?php echo $urut; ?></td>
            <td><?php echo sprintf('%08d', $data["npm"]); ?></td>
            <td><?php echo $data["nama"]; ?></td>
            <td><?php echo $data["prodi"]; ?></td>
            <td><?php echo $data["email"]; ?></td>
            <td><?php echo $data["alamat"]; ?></td>
            <td><img src="uploads/<?php echo $data["Foto"]; ?>" alt="Foto Mahasiswa" style="width: 100px; height: auto;"></td>
            <td>
                <a href="ubah-data.php?idMhs=<?= $data["idMhs"]; ?>">Edit</a> |
                <a href="hapus-data.php?idMhs=<?= $data["idMhs"]; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus data ini ?');">Hapus</a>
            </td>
        </tr>
        <?php $urut++; ?>
        <?php endwhile; ?>
    </table>
    <div style="text-align: center; margin-top: 20px;">
            <button onclick="window.location.href='tambah-data.php'" style="background-color: green; color: white; border: none; padding: 10px 20px; cursor: pointer;">Tambah Data</button>
</body>
</html>