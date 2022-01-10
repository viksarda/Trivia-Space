<html>
<head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>TRIVIA SPACE</title>
                <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
                <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
                <link rel="stylesheet" href="assets/css/Login-Form-Clean.css">
                <link rel="stylesheet" href="assets/css/styles.css">
                </head>

                
                <div class="w3-top">
                    <div class="w3-bar w3-white w3-wide w3-padding w3-card">
                        <a href="." class="w3-bar-item w3-button">Trivia Space</a>
                        <div class="w3-right w3-hide-small">
                        <a href="add.php" class="w3-bar-item w3-button">Admin</a>
                        </div>
                    </div>
                </div>

                <body style="background-color: #F1F7FC;">
                <div class="login-clean">
                        <form action="login.php" method="post">
                                <h2 class="sr-only">Login Form</h2>
								<h2>CONGRATULATIONS!!!</h2>
                                <hr>  
								<a href="." class="btn btn-primary btn-lg">Return Home</a>                                                 
                        </form>
                        
                </div>
                <script src="assets/js/jquery.min.js"></script>
                <script src="assets/js/drop-zone-.js"></script>
                <script src="assets/bootstrap/js/bootstrap.min.js"></script>
                </body>
</html>

<script>

var finish = new Audio('assets/sounds/congratulations.mp3');
finish.volume = 0.1;
finish.play();

</script>
