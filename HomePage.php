<?php
session_start();
$administrator = null;
$pom = new mysqli('localhost','root','','clothing_store');
 if(isset($_SESSION['email'])){
  $hv = 1;
  $email = $_SESSION['email'];
  $ver = "SELECT token FROM users WHERE email ='$email'";
  $r = mysqli_query($pom,$ver);
  $permission = mysqli_query($pom,"SELECT administrator FROM users WHERE email ='$email'");
  $s=mysqli_fetch_assoc($permission);
  $administrator=$s['administrator'];
 }
 else{
    $hv = 0;
 }
 ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Home Page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous"/>
    </head>
    <body>
        <div class="part">
            <div class="left">
                <h2>Menu</h2>
                <ul>
                    <li><a href="./HomePage.php"><i class="fa fa-home"></i> Home</a></li>

                    <?php if($hv !== 0 and $administrator !=1){ ?>
                    <li><a href="./Ordered.php"><i class="fa fa-credit-card-alt"></i> Ordered</a></li>
                    <?php }?>
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
                    <?php if(isset($_SESSION['email']) && $administrator == 0){ ?>
                          <a href="./Cart.php"><i class="fa fa-shopping-cart" style="color:#5C4033; font-size: 0.5em; margin-right: 30px;"></i></a>
                        <?php }?>
                      <?php if($hv == 0){ ?>
                        <a href="Login.php"><i class="fa fa-sign-in" style="color:#5C4033; font-size: 0.5em;"></i></a>
                      <?php }else {?>
                        <a href="Logout.php"><i class="fa fa-sign-out" style="color:#5C4033; font-size: 0.5em;"></i></a>
                      <?php } ?>
                    </div>
                </div> 
            </div>
        </div>
        <img src="registration.PNG" style="width:85%; height:100%; margin-left: 15%;" />
        <div style="display:flex;">
            <article class="descr">
                <i><p>Welcome to Luminique, a premium clothing brand that offers a unique 
                blend of style, comfort, and quality. Our goal is to provide you with garments that not only look 
                great but also feel amazing on your skin.</p> <br/>
                <p> Our clothing line features a wide range of styles, from casual to 
                formal, that are designed to cater to a diverse customer base. From classic pieces like t-shirts, jeans, 
                and blazers, to more fashion-forward options like maxi dresses, jumpsuits, and bomber jackets, we have something 
                for everyone. Each piece is crafted using high-quality materials and is made to last, so you can enjoy your purchases 
                for years to come.</p></i>
            </article>
            <article style="width:50%; margin: 30px; font-size: 20px; color: #5C4033">
                <p>Location: Crnogorska 18, Skopje 1000 </p> <br/>
                <p>Contact Information: +38922045113 </p> <br/>
                <p>Working hours: </p> 
                <p>Mon - Fri: 09 - 21 h</p>
                <p>Sat: 09 - 17 h </p>
                <p>Sun: Closed </p>
                <p style="text-align: left;"> <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5954.898530874172!2d21.35715175353513!3d42.00932367730144!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x13541395be174171%3A0x87fa222e838b287c!2sCrnogorska%2018%2C%20Skopje%201000%2C%20North%20Macedonia!5e0!3m2!1sen!2sus!4v1675780913841!5m2!1sen!2sus" 
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </article>
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
* {box-sizing: border-box;}
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

.descr{
  color: #5C4033;
  text-align: justify;
  font-size: 27px;
  font-weight: bolder;
  font-family: 'Times New Roman';
  margin: 30px;
  margin-left: 20%;
  padding: 30px;
  width:50%;
}

</style>

