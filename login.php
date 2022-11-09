<?php
// Vi skal starte en session, og det gør man på følgende måde:
session_start();
 
// Her tjekkes der om brugeren er logget ind
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 
// Nu skal vi skabe fobindelse til databasen ved at inkludere config.php
require_once "config.php";
 
// Værdierne skal nu defineres 
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Vi skal have fat i data fra FORMS, det gør vi på følgende måde:
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Username skal være tom 
    if(empty(trim($_POST["username"]))){
        $username_err = "Indtast dit brugernavn";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Password skal være tom 
    if(empty(trim($_POST["password"]))){
        $password_err = "Indtast din kode";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Koder og navn skal valideres med serveren
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, user_name, password FROM users WHERE user_name = ?";

        
        // anti sql-injection - Prepared statements bruges til: 
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $username);
            
            if(mysqli_stmt_execute($stmt)){
         
                mysqli_stmt_store_result($stmt);
                
                // Du skal nu tjekke om brugernavnet eksisterer, herefter skal password tjekkes 
                if(mysqli_stmt_num_rows($stmt) == 1){                    
              
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Tjek om koden er korrekt, hvis den er startes der en ny session.
                            session_start();
                            
                            // Her lager vi alt data i sessionen.
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Når brugeren er logget ind, sendes den videre til vores "welcome" site
                            header("location: welcome.php");
                        } else{
                            //Hvis brugeren indtaster forkert kode, skal det displayes på siden  
                            $login_err = "Forkert brugernavn eller kode";
                        }
                    }
                } else{
                
                    $login_err = "Forkert brugernavn eller kode";
                }
            } else{
                echo "Oops! Noget gik galt, prøv venligst igen senere.";
            }

           
            mysqli_stmt_close($stmt);
        }
    }
    
   
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="login.css">
    <title>Login</title>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function wrong()
    {
        alert('Wrong code');  
    }
    </script>
</head>
<body>

<section class="landing"> 

      <nav class="menu"> 
         <div id="nav-logo-section" class="nav-section">   
            <a class="logo-container" href="index.php">
               
            </a>
         </div>
            <div id="nav-link-section" class="nav-section"> 
               <a href="index.php"><b></b></a>
         </div>
      </nav>


        <?php 
        if(!empty($login_err)){
            echo '<div>' . $login_err . '</div>';
           
        }     
        ?>

        <div class="h1-text"><h1>Log ind</h1></div>
            

    <div class="form">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="username"><b>Brugernavn</b></label>
                <input id="username" type="text" name="username" class="form-control">
            </div>    
            <div class="form-group">
                <label for="password"><b>Kode</b></label>
                <input id="password" type="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn" value="Login">
            </div>
        </form>
    </div>


    </section>
</body>

</script>
</html>