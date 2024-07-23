<?php
//sisipkan file koneksi.php
require('koneksi.php');
//ambil idMhs dari Method GET
$idMhs = $_GET["idMhs"];
$hapus = "DELETE FROM tbl_mahasiswa WHERE idMhs = $idMhs";
$hapusData = mysqli_query($koneksi, $hapus);
$aksiHapusData = mysqli_affected_rows($koneksi);
//konfirmasi data terhapus atau tidak
if($aksiHapusData > 0){
 echo "<script>
 alert('Data berhasil dihapus');
 document.location.href = 'tampilkan-data.php';
 </script>";
}else{
 echo "<script>
 alert('Data berhasil dihapus');
 document.location.href = 'tampilkan-data.php';</script>";
}
?>
