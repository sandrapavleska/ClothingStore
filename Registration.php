<?php
if(!isset($firstName)){
    $firstName = $_POST['firstName'] ?? '';
}
if(!isset($lastName)){
    $lastName = $_POST['lastName'] ?? '';
}
if(!isset($address)){
    $address = $_POST['address'] ?? '';
}
if(!isset($email)){
    $email = $_POST['email'] ?? '';

}
if(!isset($password)){
    $password = $_POST['password'] ?? '';
}
if(!isset($phoneNumber)){
    $phoneNumber = $_POST['phoneNumber'] ?? '';
}


if(!empty($firstName) && !empty($lastName) && !empty($address) && !empty($email) && !empty($password) && !empty($phoneNumber)){
$pom = new mysqli('localhost','root','','clothing_store');
if($pom->connect_error){
    die('Connection Failed : '.$pom->connect_error);
}
else{
    $stmt = $pom->prepare("insert into users(firstName, lastName, address, email, password, phoneNumber) values(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $firstName, $lastName, $address, $email, $password, $phoneNumber);
    $stmt->execute();
    $stmt->close();
    $pom->close();
    header("Location: http://localhost/ClothingStore/Login.php");
}
}
?>


<!DOCTYPE html>
<html>
    <head>
        <title>Registration</title>
    </head>
    <body>
        <div class="main">
            <div class="header">
                <div class="leftIcon">
                    <a href="./HomePage.php">Home Page</a>
                    <p style="color: #5C4033; font-size: 75px;">Registration</p>
                </div>  
            </div>
        </div>
        <div style="display:flex;">
            <form style="width:40%;" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
                <label>First Name</label><br>
                <input type="text" name="firstName" required="required"><br>
                <label>Last Name</label><br>
                <input type="text" name="lastName" required="required"><br>
                <label>Address</label><br>
                <input type="text" name="address" required="required"><br>
                <label>E-mail</label><br>
                <input type="text" name="email" required="required"><br>
                <label>Password</label><br>
                <input type="password" name="password" required="required" placeholder="****************"><br>
                <label>Phone Number</label><br>
                <input type="text" name="phoneNumber" required="required"><br>
                <input type="submit" value="Submit" class="sub">
            </form>
            <img src="registration.PNG" style="width:60%; height:600px; margin-right: 10%" />
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
body{
   background-color: whitesmoke;
}
.main .header{
  background: whitesmoke;
  text-align: left;
  font-size: 30px;
  font-family: 'Times New Roman';
  font-weight: bold;
  margin-left: 30px;
  padding: 20px;
}
.main .header a{
    color: #5C4033;
    position: fixed;
    text-align: end;
    right: 50px;
    margin-top: 35px; 
    margin-left: 30px;
}
form{
    text-align: left;
    margin-top: 50px;
    margin-left: 5%;
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