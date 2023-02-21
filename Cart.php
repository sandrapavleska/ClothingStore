<?php
session_start();
$pom = new mysqli('localhost','root','','clothing_store');
$total= 0;
 if(isset($_SESSION['email'])){
    $hv = 1;
    $email = $_SESSION['email'];
    $current=mysqli_query($pom,"SELECT * FROM users WHERE email ='$email'");
    $current_user=mysqli_fetch_assoc($current);
    $ad=$current_user['address'];
    $cid = $current_user['ID'];

    $ver = "SELECT token FROM users WHERE email ='$email' and administrator = '0'";
    $r = mysqli_query($pom,$ver);
    if(mysqli_num_rows($r)==1){
        $pom_r = mysqli_fetch_assoc($r);
        $auth = $pom_r['token'];
        if($auth != $_COOKIE['PHPSESSID']){
            header("Location: HomePage.php");
            exit();
        }
    }
 }
 else{
    header("Location: HomePage.php");
    $hv = 0;
    exit();
 }

 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['choose']))
{
  $x=$_POST['chosen'];
  $qu1 = "UPDATE products SET cart = 0 WHERE id = '$x'";
  $r1=mysqli_query($pom,$qu1);
  if($r1){
    header("Location: Cart.php");
    exit();
  }
}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['order'])){

  $qu2="UPDATE products SET sold = 1 WHERE cart = '$cid'";
  $prod=mysqli_query($pom,$qu2);
}
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Cart</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous"/>
    </head>
    <body>
        <div class="part">
            <div class="left">
                <h2>Menu</h2>
                <ul>
                    <li><a href="./HomePage.php"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="./Ordered.php"><i class="fa fa-credit-card-alt"></i>  Ordered</a></li>
                </ul> 
                <div class="social_media">
                    <a href="https://www.facebook.com/"><i class="fa fa-facebook fa-2x"></i></a>
                    <a href="https://www.twitter.com/"><i class="fa fa-twitter fa-2x"></i></a>
                    <a href="https://www.instagram.com/"><i class="fa fa-instagram fa-2x"></i></a>
                </div>
            </div>
            <div class="main">
                <div class="header">
                    <a href="Luminique.php" style="text-decoration:none;"><i>Luminique</i></a>
                    <div class="icons">
                      <?php if($hv == 0){ ?>
                        <a href="Login.php"><i class="fa fa-sign-in " style="color: #5C4033; font-size: 0.5em;"></i></a>
                      <?php }else {?>
                        <a href="Logout.php"><i class="fa fa-sign-out" style="color: #5C4033; font-size: 0.5em;"></i></a>
                      <?php } ?>
                    </div>   
                </div>
                <div class="prod">
                <p style="text-align: center; font-size: 20px;">Address: " <?php echo $ad; ?> "</p>
                  <?php
                          $qu = " select * from products where cart='$cid' and sold=0";
                          $rez = mysqli_query($pom, $qu);
                  
                          while ($d = mysqli_fetch_assoc($rez)) {
                        ?>
                      
                          <div class="item">
                            <div class="prodimg">
                              <img src="./images/<?php echo $d['picture']; ?>" alt="Picture" style="height:100%">
                            </div>
                            <div class="prodtxt">
                              <h3><?php echo $d['model']; ?></h3><br><br>   
                              <p class="price">$<?php echo $d['price']; ?></p><br>
                              <form action="Cart.php" method="post">
                                <input type="hidden" name="chosen" value="<?php echo $d['id']; ?>"/>
                                <input type="submit" class="sub2" name="choose" value="Remove this item from Cart" />
                              </form>
                            </div>
                          </div>
                        <?php
                        }
                  ?>
                </div>
                <div class="total">
                  <?php
                    $qu = " select * from products where cart = '$cid' and sold=0";
                    $rez = mysqli_query($pom, $qu);
            
                    while ($d = mysqli_fetch_assoc($rez)) {
                      $total += $d['price'];
                    }
                  ?>
                    <h3 style="position: center">ORDER DETAILS:</h3>
                    <br><hr></hr><br> 
                    <p>Products: <span class="ord">$<?php echo $total; ?></span></p> <br>
                    <p>Total:<span class="ord" style="font-weight: bold;">$<?php echo $total; ?></span>
                  <div style="text-align: left;">
                    <br><br>
                    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                      <button class="sub" type="submit" name="order">Order</button>
                    </form>
              </div>
              <br>
            </div>
    </div>
</body>
</html>
<style>
    *{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  list-style: none;
  text-decoration: none;
}

body{
   background-color: whitesmoke;
}

.part{
  display: flex;
  position: relative;
}

.part .left{
  width: 300px;
  height: 100%;
  background: #5C4033;
  padding: 30px 0px;
  position: fixed;
}

.part .left h2{ 
  color: whitesmoke;
  text-transform: uppercase;
  text-align: left;
  margin-bottom: 20px;
  margin-left: 20px;
}

.part .left ul li{
  padding: 20px;
  border-top: 2px solid whitesmoke;
}    

.part .left ul li a{
  color: whitesmoke;
  font-weight: bolder;
  font-size: 25px;
  display: block; 
}

.part .left .social_media{
  position: absolute;
  bottom: 0;
  left: 10px;
  display: flex;
  margin-bottom: 15%;
}

.part .left .social_media a{
  display: block;
  width: 60px;
  height: 50px;
  line-height: 60px;
  background: whitesmoke;
  color: #5C4033;
  text-align: center;
  margin: 0 15px;
  border-radius: 15px;
}

.part .main{
  width: 100%;
  margin-left: 400px;
}

.part .main .header{
  padding: 10px;
  text-align: center;
  font-size: 90px;
  font-family: 'Times New Roman';
  font-weight: bolder;
  margin-bottom: 10px;
  margin-right: 100px;
}

.part .main .header a{
    color: #5C4033;
}

.icons {
    position: fixed;
    right: 0;
    top: 0;
    margin-top: 20px;
    margin-right: 20px;
}
.prod{
    display: block;
    float: left;
    width: 60%;
    border: 3px solid #5C4033;
    padding: 10px;
}

.item {
  display:flex;
  width: 100%;
  font-family: 'Times New Roman';
  font-size: 20px;
  color: #5C4033;
  padding: 30px;
  background: whitesmoke;
}

.prodimg{
  max-width: 50%;
  height: 200px;
  margin: 10px;
  margin-left:20px;
}

.prodtxt{
  width: 100%;
  text-align:right; 
}

.price {
  color: #5C4033;
  font-size: 20px;
  text-align: right;
  font-weight: bold;
}

.ord{
  display: inline-block;
  margin-left: 150px;
}

.total{
    display: block;
    float: right;
    width: 30%;
    margin-right: 50px;
    margin-top: 30px;
    padding: 30px;
    background-color:burlywood;
}

.sub {
  border-radius: 15px;
  border-color: #5C4033;
  background-color: #5C4033;
  color: whitesmoke;
  text-align: center;
  font-size: 20px;
  padding: 5px;
  outline: 0;
  width: 50%;
}

.sub2 {
  border-radius: 15px;
  border-color: #5C4033;
  background-color: #5C4033;
  color: whitesmoke;
  text-align: center;
  font-size: 20px;
  padding: 5px;
  outline: 0;
  width: 70%;
}
</style>