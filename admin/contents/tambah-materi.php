<?php
include '../../php-engine/connect_tadica_db.php';

$nama_materi = $_POST['nama_materi'];
$id_kelas = $_POST['id_kelas'];
$nama_matpel = $_POST['nama_matpel'];
$nama_file = basename($_FILES["nama_file"]["name"]);
$id_soal = $_POST['id_soal'];
if ($id_soal == '') {
    $id_soal = "DEFAULT";
}

// if ($_POST['add-new-matpel'] == "true") {
//     mysqli_query($connect, $query);
// }

$target_dir = "../../assets/pdf/materi/";
$target_file = $target_dir . $nama_file;

if ($_FILES['nama_file']['type'] == "application/pdf") {
    if (file_exists($target_file)) {
        echo "file-exists";
    }
    else {
        if (move_uploaded_file($_FILES['nama_file']['tmp_name'], $target_file)) {
            if ($_POST['add-new-matpel'] == "true") {
                $query = "INSERT INTO matpel VALUES (DEFAULT, '$nama_matpel')";
                mysqli_query($connect, $query);
            }
    
            $query = "SELECT id_matpel FROM matpel WHERE nama_matpel = '$nama_matpel'";
            $result = mysqli_query($connect, $query);
            $id_matpel = mysqli_fetch_array($result)['id_matpel'];
    
            $query = "INSERT INTO download VALUES (DEFAULT, $id_kelas, $id_matpel, '$nama_file', true, DEFAULT)";
            mysqli_query($connect, $query);
            
            $query = "SELECT id_download FROM download WHERE nama_file = '$nama_file'";
            $result = mysqli_query($connect, $query);
            $id_download = mysqli_fetch_array($result)['id_download'];
            
            $query = "INSERT INTO materi VALUES (DEFAULT, $id_kelas, $id_matpel, $id_soal, '$nama_materi', $id_download, DEFAULT, DEFAULT)";
            mysqli_query($connect, $query);
            echo "success";
        } else {
            echo "not-success";
        }
    }
}
else {
    echo "not-pdf";
}
?>