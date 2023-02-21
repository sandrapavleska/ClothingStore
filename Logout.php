<?php
 session_start();
 $pom = new mysqli('localhost','root','','clothing_store');
 $email = $_SESSION["email"];
 $base_qu = "UPDATE users SET token = '' WHERE email = '$email'";
 $rez = mysqli_query($pom,$base_qu);
 if($rez){
    unset($_SESSION['email']);
    session_destroy();
    header("Location: HomePage.php");
    exit();
 }
 ?>