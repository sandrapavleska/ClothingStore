<?php
session_start();
$pom = new mysqli('localhost','root','','clothing_store');
 if(isset($_SESSION['email'])){
  $hv = 1;
  $email = $_SESSION['email'];
  $ver = "SELECT token FROM users WHERE email ='$email'";
  $r = mysqli_query($pom,$ver);
 }
 else{
    $hv = 0;
 }

if (isset($_POST['upload'])) {
 
    $picture = $_FILES["uploadfile"]["name"];
    $temp = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./images/" . $picture;

    if(!isset($model)){
        $model = $_POST['model'] ?? '';
    }
    if(!isset($category)){
        $category = $_POST['category'] ?? '';
    }
    if(!isset($size)){
        $size = $_POST['size'] ?? '';
    }
    if(!isset($price)){
        $price = $_POST['price'] ?? '';
    }

    if($pom->connect_error){
        die('Connection Failed : '.$pom->connect_error);
    }
    else{
        $stmt = $pom->prepare("insert into products(picture, model, price, size, category) values(?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $picture, $model, $price, $size, $category);
        $stmt->execute();
        $stmt->close();
        $pom->close();
        header("Location: Luminique.php");
    }
 
    if (move_uploaded_file($temp, $folder)) {
        echo "<h3>  Successful upload!  </h3>";
    } else {
        echo "<h3>  Failed to upload!  </h3>";
    }
}
?>
 
<!DOCTYPE html>
<html>
    <head>
        <title>New Product</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous"/>
    </head>
 
<body>
<div class="part">
    <div class="main">
        <div class="header">
            <div class="leftIcon">
                <a href="./Luminique.php">  Back </a>
            </div>  
            <p style="color: #5C4033; font-size: 75px; text-align: center">Add New Product</p>
            <div class="rightIcons">
                <?php if($hv == 0){ ?>
                <a href="Login.php"><i class="fa fa-sign-in" style="color:#5C4033;"></i></a>
                <?php } else {?>
                <a href="Logout.php"><i class="fa fa-sign-out" style="color:#5C4033;"></i></a>
                <?php } ?>
            </div>
        </div>

        <div id="content">
            <form method="POST" action="" enctype="multipart/form-data">
                <label>Model</label>
                <input type="text" name="model" class="square" required="required"><br>
                <label>Category</label>
                <input type="text" name="category" class="square" required="required"><br>
                <label>Size</label><br>
                <input type="number" name="size" class="square" required="required"><br>
                <label>Price</label><br>
                <input type="number" name="price" class="square" required="required"><br>
                <label>Picture</label><br>

                <div>
                    <br>
                    <input class="form-settings" type="file" name="uploadfile" value="" />
                </div>
                <div>
                    <br>
                    <button class="sub" type="submit" name="upload">UPLOAD</button>
                </div>
            </form>
        </div>
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
}

#content{
    width: 50%;
	justify-content: center;
	align-items: center;
	margin: 40px auto;
	border: 1px solid;
    border-radius: 15px;
    font-size: 20px;
    background: #5C4033;
    color: whitesmoke;
    font-weight: bolder;
}

.rightIcons {
    position: fixed;
    right: 0;
    top: 0;
    margin-top: 50px;
    margin-right: 30px;
}
.leftIcon{
    position: fixed;
    margin-top: 30px;
    margin-left: 20px;
    color: whitesmoke;
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
}
.part .main .header{
  background: whitesmoke;
  text-align: center;
  font-size: 30px;
  font-family: 'Times New Roman';
  font-weight: bold;
  margin-left: 30px;
  padding: 20px;
}

.part .main .header a{
    color: #5C4033;
}

form{
	width: 50%;
	margin: 30px auto;
}

.sub{
    border-radius: 10px;
    padding: 10px 10px;
    font-size: 15px;
    cursor: pointer;
    background-color: whitesmoke;
}
.square{
    margin: 10px;
    padding: 10px;
}
.form-settings{
    margin-left: 15px;
    padding: 5px;
    font-size: 15px;
}