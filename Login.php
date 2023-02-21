<?php
session_start();
$pom = new mysqli('localhost','root','','clothing_store');
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $qu = "SELECT * FROM users WHERE email = '$email' and password = '$password'";
    $rez = mysqli_query($pom, $qu);
    if(mysqli_num_rows($rez) == 1){
        $auth = session_id();
        $_SESSION["email"] = $email;
        $auth_qu = "UPDATE users SET token = '$auth' WHERE email = '$email'";
        $r = mysqli_query($pom,$auth_qu);
        if($r){
            header("Location: HomePage.php");
            exit();
        }
    }
    else{
        $error = 1;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <div class="main">
            <div class="header">
                <div>
                    <a href="./HomePage.php" style="text-decoration: none;">Home Page</a>
                    <p style="color: #5C4033; font-size: 75px;">Login</p>
                </div>
            </div>
        </div>
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
            <label>Email</label><br/>
            <input type="text" name="email"> <br/>
            <label>Password</label><br/>
            <input type="password" name="password" placeholder="*************"><br/>
            <input type="submit" value="Login" class="sub" name="login">
            <?php if(isset($error) and $error==1){?>
               <p>Incorrect username or password. Try again!</p>
            <?php } ?>
        </form>
        <div style="text-align:center; color: #5C4033; font-size: 20px; padding-top: 20px;">No account? <a href="Registration.php" style="color: #5C4033;">Create one!</a></div>
    </body>
</html>
<style>
*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  list-style: none;
}
body{
   background-color: whitesmoke;
}
.main .header{
  background: whitesmoke;
  text-align: center;
  font-size: 30px;
  font-family: 'Times New Roman';
  font-weight: bolder;
  padding: 20px;
}
.main .header a{
    color: #5C4033;
    position: fixed;
    text-align: end;
    right: 50px;
    margin-top: 20px; 
    margin-left: 30px;
}

form{
    text-align: center;
    margin-top: 50px;
    font-size: 20px;
    font-family: 'Times New Roman';
    font-weight: bolder;
}
form input{
    padding: 10px;
    margin: 10px;
    font-size: 15px;
}

.sub{
    border-radius: 10px;
    padding: 10px 10px;
    font-size: 15px;
    background-color: #5C4033;
}
</style>