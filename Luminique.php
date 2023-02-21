<?php
session_start();
$pom = new mysqli('localhost','root','','clothing_store');

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

 $as='all_size';
 $ac='all_cat';
 if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['filter']))
{
  if (isset($_POST['categoryFilter']))
    $ac=$_POST['categoryFilter'];
  if (isset($_POST['sizeFilter'])) 
    $as=$_POST['sizeFilter'];
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['choose']))
{
  $email = $_SESSION['email'];
  $uid= mysqli_query($pom,"SELECT ID FROM users WHERE email ='$email'");
  $UID=mysqli_fetch_assoc($uid);
  $u=$UID['ID'];
  $x=$_POST['chosen'];
 
  $qu1 = "UPDATE products SET cart = '$u' WHERE id = '$x'";
  $r1=mysqli_query($pom,$qu1);
  if($r1){
    header("Location: Cart.php");
    exit();
  }
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['del']))
{
  $item_x=$_POST['delete_x'];
  $sql = "DELETE FROM products WHERE id='$item_x'";

  if (mysqli_query($pom, $sql)) {
    header("Location: Luminique.php");
    exit();
  } else {
    echo "Item not deleted: " . mysqli_error($pom);
  }
}
 ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Luminique</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"  crossorigin="anonymous"/>
    </head>

    <body>
        <div class="part">
            <div class="left">
                <h2>Menu</h2>
                <ul>
                    <li><a href="./HomePage.php"><i class="fa fa-home"></i> Home</a></li>
                    <?php if($administrator == 0){ ?>
                    <li><a href="./Ordered.php"><i class="fa fa-credit-card-alt"></i> Ordered</a></li>
                    <?php }  ?>
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
                    <div class="rightIcons">
                      <?php if($hv == 0){ ?>
                        <a href="Login.php"><i class="fa fa-sign-in" style="color:#5C4033; font-size: 0.5em;"></i></a>
                      <?php }else {?>
                        <?php if($administrator == 0){ ?>
                          <a href="./Cart.php"><i class="fa fa-shopping-cart" style="color:#5C4033; font-size: 0.5em; margin-right: 30px;"></i></a>
                        <?php }?>
                        <a href="Logout.php"><i class="fa fa-sign-out" style="color:#5C4033; font-size: 0.5em;"></i></a>
                      <?php } ?>
                    </div>
                </div>

                <?php if($administrator == 1)
                {?> 
                  <p><a href="NewProduct.php" class="prod_add"><i>Add New Product</i></a></p>
                <?php } ?>
                <?php if($administrator == 0){?>
                  <form action="Luminique.php" method="post">
                   <p style="text-align: left;"> 
                   <select name="categoryFilter">  
                      <option value="all_cat">Category</option>}  
                      <option value="blazers">Blazers</option> 
                      <option value="trousers">Trousers</option>
                      <option value="shirts">Shirts</option> 
                    </select>  
                    <select name="sizeFilter">  
                      <option value="all_size">Size</option>}  
                      <option value="36">36</option>  
                      <option value="38">38</option>  
                      <option value="40">40</option>  
                      <option value="42">42</option>  
                      <option value="44">44</option>  
                    </select>
                    &ensp;
                    <input type="submit" class="button" name="filter" value="Filter" />
                  </p> 
                  </form>  <?php  }   ?>
                  
                <div>
                <?php
                  if($as=='all_size' and $ac=='all_cat'){
                    $qu = " select * from products where sold = 0";
                    $rez = mysqli_query($pom, $qu);
                  }else if($as=='all_size' and $ac!='all_cat'){
                    $qu = " select * from products where category='$ac' and sold=0";
                    $rez = mysqli_query($pom, $qu);
                  }else if($as!='all_size' and $ac=='all_cat'){
                    $qu = " select * from products where size='$as' and sold=0";
                    $rez = mysqli_query($pom, $qu);
                  }else if($as!='all_size' and $ac!='all_cat'){
                    $qu = " select * from products where category='$ac' and size='$as' and sold=0";
                    $rez = mysqli_query($pom, $qu);
                  }
                          while ($d = mysqli_fetch_assoc($rez)) {
                        ?>
                            <div class="prod_box">
                              <?php if($administrator == 1){?>
                                <form action="Luminique.php" method="post">
                                    <input type="hidden" name="delete_x" value="<?php echo $d['id']; ?>"/>
                                    <input type="submit" class="sub" name="del" value="delete item" />
                                </form>

                              <?php } ?>
                              <div class="prodimg">
                                <a href="Products.php?var=<?php echo $d['id'] ?>">
                                <img src="./images/<?php echo $d['picture']; ?>" alt="Picture" style="height:100%; width:100%"></a>
                              </div>
                              <h3><?php echo $d['model']; ?></h3>
                              <p class="price">$<?php echo $d['price']; ?></p>

                              <?php if($administrator == 0){?>
                              <form action="Luminique.php" method="post">
                                 <input type="hidden" name="chosen" value="<?php echo $d['id']; ?>"/>
                                 <input type="submit" class="sub" name="choose" value="Add to Shopping Cart" />
                              </form>
                              <?php } ?>
                              
                            </div> 
                        <?php
                 }
                  ?>
                </div> 
            </div>
        </div>
    </body>
</html>
<style>

*{
  margin: 0;
  padding: 0;
  text-decoration: none;
  box-sizing: border-box;
  list-style: none;;
}

body{
   background-color: whitesmoke;
}
.rightIcons {
    position: fixed;
    right: 0;
    top: 0;
    margin-top: 10px;
    margin-right: 20px;
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
  text-align: left;
  font-size: 75px;
  font-family: 'Times New Roman';
  font-weight: bold;
  margin-bottom: 10px;
}

.part .main .header a{
    color: #5C4033;
}

.prod_add {
  border-radius: 15px;
  border-color: #5C4033;
  background-color: #5C4033;
  color: whitesmoke;
  width: 100%;
  font-size: 25px;
  font-weight: bold;
  padding: 20px;
}

.prod_box {
  width: 45%;
  height: 900px;
  font-family: 'Times New Roman';
  font-size: 20px;
  text-align: center;
  color: #5C4033;
  float: left;
  margin: 30px 10px 100px 10px;
}

.prodimg{
  width: 100%;
  height: 75%;
  margin-top: 10px;
}

.price {
  color: #5C4033;
  font-size: 25px;
  font-weight: bolder;
  text-align: center;
}

.prod_box .sub {
  border-radius: 15px;
  border-color: #5C4033;
  background-color: #5C4033;
  color: whitesmoke;
  text-align: center;
  width: 100%;
  font-size: 25px;
}

