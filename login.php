<!Doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Halaman Siswa TADICA</title>

        <!--Bootstrap-->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

        <!--jQuery-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <style>
            body {
                background-color: #22222a;
            }

            #form-container {
                display: table;
                position: absolute;
                height: 100%;
                width: 100%;
            }
            #form-outer {
                display: table-cell;
                vertical-align: middle;
            }
            #form-content {
                margin-left: auto;
                margin-right: auto;
                max-width: 400px;
                background-color: #fff;
                border-radius: 8px;
            }

            #login {
                padding: 10px;
            }
            #title {
                padding: 10px;
                background-color: #c8c8c8;
            }
            #title h1 {
                font-size: 30px;
                margin: 0;
                text-align: center;
            }
            #login-error {
                font-size: 15px;
                margin-left: 8px;
                color: #b00000;
            }
        </style>

        <script>
        $(document).ready(function() {
            $("input#username").on({
                keydown: function(e) {
                    if (e.which === 32)
                    return false;
                },
                change: function() {
                    this.value = this.value.replace(/\s/g, "");
                }
            });
        });
        </script>
    </head>
    <?php
        include 'php-engine/connect_tadica_db.php';
        session_start();

        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            header('location:dashboard.html');
        }
        else {
            if (isset($_POST['username']) && isset($_POST['password'])) {
                $username=$_POST['username'];
                $password=sha1($_POST['password']);
                $query = "SELECT username, password FROM siswa WHERE username='$username' AND password='$password';";
                $login_data = mysqli_query($connect, $query);

                if(!$connect) {
                    die("CONNECTION FILED : " . mysqli_connect_error());
                }
                else if (mysqli_num_rows($login_data) > 0) {        
                    $query = "SELECT id_siswa FROM siswa ORDER BY id_siswa DESC LIMIT 1";
                    $result = mysqli_query($connect, $query);            
                    $_SESSION['loggedin'] = true;
                    $_SESSION['id-siswa'] = mysqli_fetch_array($result)['id_siswa'];
                    header('location:dashboard.html');
                }
                else {
                    $_SESSION['loggedin'] = false;
                    $loginError = true;
                }
                mysqli_close($connect);
            }
        }
    ?>
    <body>
        <div id="form-container">
            <div id="form-outer">
                <div id="form-content">
                    <div id="title">
                        <h1>Login Siswa</h1>
                    </div>
                    <form method="POST" action="" id="login">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus> <br/>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required> <br/>
                        <input type="submit" value="Masuk" id="masuk" class="btn btn-primary">
                        <span id="login-error">
                            <?php
                                if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == false) {
                                    echo "Username atau Password salah!";
                                    session_destroy();
                                }
                            ?>
                        </span>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>