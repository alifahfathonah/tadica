<?php
include '../php-engine/connect_tadica_db.php';

$id_user = $_POST['id_user'];
$siswa = $_POST['siswa'];
$pesan = $_POST['pesan'];

$query = "INSERT INTO public_chat VALUES (DEFAULT, $id_user, $siswa, '".stripslashes(htmlspecialchars($pesan))."', DEFAULT)";
$result = mysqli_query($connect, $query);

if ($result) {
    echo "Pesan terkirim";
}
else {
    echo "Pesan gagal terkirim";
}
?>