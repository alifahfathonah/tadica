<?php
include '../php-engine/connect_tadica_db.php';
$id_siswa = $_POST['id-siswa'];
$id = $_POST['id'];
$jumlah = $_POST['jumlah-soal'];

$query = "SELECT id_pilihan FROM pilihan WHERE id_pertanyaan IN (SELECT id_pertanyaan FROM pertanyaan WHERE id_soal = $id) AND benar = 1";
$result = mysqli_query($connect, $query);
$benar = array();

while ($row = mysqli_fetch_array($result)) {
    array_push($benar, $row['id_pilihan']);
}

if (isset($_POST['jawaban'])) {
    $jawaban = $_POST['jawaban'];
    $hasil = count(array_intersect($benar, $jawaban));
}

$query = "INSERT INTO ujian VALUES (DEFAULT, $id, $id_siswa, $hasil*100/$jumlah, $hasil, $jumlah-$hasil, DEFAULT);";
$result = mysqli_query($connect, $query);

if ($result) {
    echo "Success";
}
else {
    echo "Failed";
}

?>