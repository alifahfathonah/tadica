<?php
include '../../php-engine/connect_tadica_db.php';

$nama_soal = $_POST['nama_soal'];
$nama_matpel = $_POST['nama_matpel'];
$id_kelas = $_POST['id_kelas'];
$nama_file = basename($_FILES["nama_file"]["name"]);;
$id_materi = $_POST['id_materi'];
$pertanyaan = $_POST['pertanyaan'];
$benar = $_POST['benar'];
$jawaban = $_POST['jawaban'];

$jumlahSoal = count($pertanyaan);
$jumlahJawaban = count($jawaban);

if ($id_materi == '') {
    $id_materi = "DEFAULT";
}

$target_dir = "../../assets/pdf/soal/";
$target_file = $target_dir . $nama_file;

$output = '';

if ($_FILES['nama_file']['type'] == "application/pdf") {
    if (file_exists($target_file)) {
        $output = "file-exists";
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

            $query = "INSERT INTO download VALUES (DEFAULT, $id_kelas, $id_matpel, '$nama_file', false, DEFAULT)";
            mysqli_query($connect, $query);

            $query = "SELECT id_download FROM download WHERE nama_file = '$nama_file'";
            $result = mysqli_query($connect, $query);
            $id_download = mysqli_fetch_array($result)['id_download'];

            $query = "INSERT INTO soal VALUES (DEFAULT, $id_kelas, $id_matpel, $id_materi, '$nama_soal', $id_download, DEFAULT, DEFAULT)";
            mysqli_query($connect, $query);

            $query = "SELECT id_soal FROM soal ORDER BY id_soal DESC LIMIT 1";
            $result = mysqli_query($connect, $query);
            $id_soal = mysqli_fetch_array($result)['id_soal'];

            for ($i=0; $i < $jumlahSoal; $i++) { 
                $query = "INSERT INTO pertanyaan VALUES (DEFAULT, $id_soal, '$pertanyaan[$i]')";
                mysqli_query($connect, $query);

                $query = "SELECT id_pertanyaan FROM pertanyaan ORDER BY id_pertanyaan DESC LIMIT 1";
                $result = mysqli_query($connect, $query);
                $id_pertanyaan = mysqli_fetch_array($result)['id_pertanyaan'];

                for ($j=$i*5; $j < ($i+1)*5; $j++) { 
                    if ($j == (int) $benar[$i]) {
                        $query = "INSERT INTO pilihan VALUES (DEFAULT, $id_pertanyaan, '$jawaban[$j]', true)";
                    }
                    else {
                        $query = "INSERT INTO pilihan VALUES (DEFAULT, $id_pertanyaan, '$jawaban[$j]', false)";
                    }
                    mysqli_query($connect, $query);
                }
            }

            $output = "success";
        }
    }
}
else {
    $output = "not-pdf";
}

echo $output;
mysqli_close($connect);
?>