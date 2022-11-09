<?php
// Sessionen skal startes
session_start();
 
// Serveren skal tjekke om brugeren er logget ind, hvis ikke skal de viderestilles til login siden
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
   
    <style>
        body{ font: 14px sans-serif; text-align: center; background-color: rgb(197, 217, 244); }
        a.btn{
          text-align: center;
        border-radius:10px;
        border:1px solid #4dacccc6;
        padding: 10px 50px;
        color: black;
        background-color:  #4dacccd6;
        cursor: pointer;
        font-weight: 700;
        margin: 100px;
        }
        h1{
            margin: 100px;
        }
        a.btn:hover
        {
        background-color:  #4daccc7d;
        border:1px solid #4daccc;
        }
    </style> 
</head>
<body>
    <!-- Her skrives overskrift samt en php-kode, der gør at brugerens username bliver displayet, når de er logget ind -->
    <h1 class="my-5">Hej, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Du er nu logget ind</h1>
    <p>
        <!-- <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a> -->
        <a href="logout.php" class="btn">Log ud</a>
    </p>
</body>
</html>