<?php
    include 'php-engine/connect_tadica_db.php';

    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $asal_sekolah = $_POST['asal_sekolah'];
    $id_kelas = $_POST['id_kelas'];
    $username = $_POST['username'];
    $password = sha1($_POST['password']);
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];

    // echo $tanggal_lahir;

    $query = "INSERT INTO siswa VALUES (DEFAULT, '$nama', $jenis_kelamin, '$alamat', '$tanggal_lahir', 
    '$asal_sekolah', $id_kelas, '$username', '$password', '$email', '$no_hp', true)";
    $result = mysqli_query($connect, $query);
    if($result) {
        $query = "SELECT id_siswa FROM siswa ORDER BY id_siswa DESC LIMIT 1";
        $result = mysqli_query($connect, $query);
        $_SESSION['loggedin'] = true;
        $_SESSION['id-siswa'] = mysqli_fetch_array($result)['id_siswa'];
        header('location: login.php');
    }

    mysqli_close($connect);
?>