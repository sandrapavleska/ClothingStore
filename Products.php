<?php
session_start();
$pom = new mysqli('localhost','root','','clothing_store');
$value = $_REQUEST['var'];
$qu = " select * from products where id='$value'";
$rez = mysqli_query($pom, $qu);
$d = mysqli_fetch_assoc($rez);

 if(isset($_SESSION['email'])){
    $hv = 1;
    $email = $_SESSION['email'];
    $permission = mysqli_query($pom,"SELECT administrator FROM users WHERE email ='$email'");
    $s=mysqli_fetch_assoc($permission);
    $administrator=$s['administrator'];
    $ver = "SELECT token FROM users WHERE email ='$email'";
    $r = mysqli_query($pom,$ver);
    if(mysqli_num_rows($r)==1){
        $pom_r = mysqli_fetch_assoc($r);
        $auth = $pom_r['token'];
        if($auth != $_COOKIE['PHPSESSID']){
            header("Location: HomePage.php");
            exit();
        }
    }
    else{
        header("Location: HomePage.php");
        exit();
    }
 }
 else{
    header("Location: HomePage.php");
    $hv = 0;
    exit();
 }
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Products</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous"/>
    </head>
    <body>
        <div class="part">
            <div class="main">
              <div class="header">
                <div class="back">
                  <a href="./Luminique.php">Back</a>
                </div>
                <span><i>Information about the product:</i></span>
              </div>
              <div class="content">
                <div class="prod">
                  <div class="prodimg">
                    <img src="./images/<?php echo $d['picture']; ?>" alt="Picture" style="height:100%; width:100%">
                  </div>
                </div>
                <div class="info">
                  <h2 style="font-size: 30px;"><?php echo $d['model']; ?></h2>
                  <div class="more_details">
                    <p >Category: <?php echo $d['category']; ?></p>
                    <p>Size: <?php echo $d['size']; ?></p>
                    <p>Price: $<?php echo $d['price']; ?></p>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </body>
</html>
<style>

*{
  margin: 0;
  padding: 0;
  list-style: none;
  text-decoration: none;
  box-sizing: border-box;
  color: #5C4033;
}

.back{
    position: fixed;
    left: 0;
    top: 0;
    margin-top: 30px;
    margin-left: 30px;
    font-size: 30px;
}

body{
   background-color: whitesmoke;
}

.part{
  display: flex;
  position: relative;
}

.part .main{
  width: 100%;
  margin-left: 200px;
}

.part .main .header{
  padding: 10px;
  text-align: left;
  font-size: 75px;
  font-family: 'Times New Roman';
  font-weight: bold;
  margin-bottom: 10px;
}

.content{
  display: flex;
}

.prod {
  display: block;
  float: left;
  max-width: 50%;
  height: 750px;
  text-align: center;
  margin: 10px 10px 100px 100px;
}

.prodimg{
  width: 100%;
  height: 100%;
  margin-top: 10px;
}

.info{
    display: block;
    float: right;
    width: 25%;
    height: 350px;
    margin: 200px 10px 100px 100px;
    padding: 50px;
    background-color: whitesmoke; 
    border: 3px solid #5C4033;
    border-radius: 20px;
}

.info .more_details {
  color: #5C4033;
  font-size: 30px;
  margin-top: 30px;
}
