<?php
    include '../../php-engine/connect_tadica_db.php';

    $id_materi = $_POST['id_materi'];
    $nama_materi = $_POST['nama_materi'];
    $id_kelas = $_POST['id_kelas'];
    $nama_matpel = $_POST['nama_matpel'];
    $nama_file = basename($_FILES["nama_file"]["name"]);
    $id_soal = $_POST['id_soal'];
    if ($id_soal == '') {
        $id_soal = "DEFAULT";
    }

    $id_download = $_POST['id_download'];
    if ($_POST['add-new-matpel'] == "true") {
        $query = "INSERT INTO matpel VALUES (DEFAULT, '$nama_matpel')";
        mysqli_query($connect, $query);
    }
    $query = "SELECT id_matpel FROM matpel WHERE nama_matpel = '$nama_matpel'";
    $result = mysqli_query($connect, $query);
    $id_matpel = mysqli_fetch_array($result)['id_matpel'];
    $fileChanged = FALSE;
    $noError = TRUE;

    if ($nama_file != '') {
        $target_dir = "../../assets/pdf/materi/";
        $target_file = $target_dir . $nama_file;
        if ($_FILES['nama_file']['type'] == "application/pdf") {
            if (file_exists($target_file)) {
                echo "file-exists";
                $noError = FALSE;
            }
            else {
                if (move_uploaded_file($_FILES['nama_file']['tmp_name'], $target_file)) {
                    
                    $query = "SELECT nama_file FROM download WHERE id_download = $id_download";
                    $result = mysqli_query($connect, $query);
                    $nama_fileOLD = mysqli_fetch_array($result)['nama_file'];
                    unlink($target_dir.$nama_fileOLD);
    
                    $query = "DELETE FROM download WHERE id_download = $id_download";
                    mysqli_query($connect, $query);

                    $fileChanged = TRUE;

                    echo "success";
                } else {
                    echo "not-success";
                    $noError = FALSE;
                }
            }
        }
        else {
            echo "not-pdf";
            $noError = FALSE;
        }
    }
    if ($fileChanged == TRUE) {
        $query = "INSERT INTO download VALUES (DEFAULT, $id_kelas, $id_matpel, '$nama_file', true, DEFAULT)";
        $result = mysqli_query($connect, $query);
    
        $query = "SELECT id_download FROM download WHERE nama_file = '$nama_file'";
        $result = mysqli_query($connect, $query);
        $id_download = mysqli_fetch_array($result)['id_download'];
    }
    
    if ($noError == TRUE) {
        $queryChange = "UPDATE materi SET id_kelas = $id_kelas, id_matpel = $id_matpel, id_soal = $id_soal, nama_materi = '$nama_materi', id_download = $id_download WHERE id_materi = $id_materi";
        mysqli_query($connect, $queryChange);
    
        $query = "DELETE FROM matpel WHERE id_matpel NOT IN (SELECT id_matpel FROM soal) AND id_matpel NOT IN (SELECT id_matpel FROM materi)";
        mysqli_query($connect, $query);
    }
    mysqli_close($connect);
?>