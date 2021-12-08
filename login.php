<?php
include('classes/DB.php');

if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        if (DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {

                if (password_verify($password, DB::query('SELECT password FROM users WHERE username=:username', array(':username'=>$username))[0]['password'])) {
                        $cstrong = True;
                        $token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
                        $user_id = DB::query('SELECT id FROM users WHERE username=:username', array(':username'=>$username))[0]['id'];
                        DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
                        setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
                        setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE);
                        header("Location: index.php");

                } else {
                        echo 'Incorrect Password!';
                }

        } else {
                echo 'User does not exist!';
        }

}

?>
<html>

        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Viksagram</title>
        <link rel="icon" href="assets/img/Logoicon.png">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
        <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
        <link rel="stylesheet" href="assets/css/styles.css">
        </head>

        <body style="background-color: #F1F7FC;">
        <div class="login-clean">
                <form action="login.php" method="post">
                        <h2 class="sr-only">Login Form</h2>
                        <div class="illustration"><img src="assets/img/Logo.png" style="max-width:60%"></i></div>
                        <hr>
                        <div class="form-group">
                                <input class="form-control" type="text" id="username" name="username" placeholder="Username">
                        </div>
                        <div class="form-group">
                                <input class="form-control" type="password" id="password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block" name="login" id="login" type="button" data-bs-hover-animate="shake">Log In</button>
                        </div>
                        <br>
                        <a href="forgot-password.php" class="forgot">Forgot your email or password?</a>
                        <br>
                        <a href="create-account.php" class="forgot" style="font-size:large; color:#f4476b">Sign Up</a>
                        <br>
                        
                </form>
                
        </div>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/drop-zone-.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- <script src="assets/js/bs-animation.js"></script> -->
        </body>

</html>

