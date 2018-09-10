<?php
include '../php-engine/connect_tadica_db.php';

$query = "SELECT * FROM public_chat ORDER BY id_pesan LIMIT 50";
$result = mysqli_query($connect, $query);

while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
    if ($row[2] == '0') {
        $query = "SELECT nama FROM layanan_informasi WHERE id_user = $row[1]";
        $resnama = mysqli_query($connect, $query);
        $nama = mysqli_fetch_array($resnama)['nama'];
        echo "<div>";
        echo "<b>Admin $nama : </b> $row[3]";
        echo "</div>";
    }
    else {
        $query = "SELECT nama FROM siswa WHERE id_siswa = $row[1]";
        $resnama = mysqli_query($connect, $query);
        $nama = mysqli_fetch_array($resnama)['nama'];
        echo "<div>";
        echo "<b>Siswa $nama : </b> $row[3]";
        echo "</div>";
    }
}
?>