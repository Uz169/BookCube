<?php
session_start();
include("connection.php");
include("functions.php");

$error_user_name = "";
$error_password = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = htmlspecialchars($_POST['user_name']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($user_name)) {
        $error_user_name = "Username is required";
    }

    if (empty($password)) {
        $error_password = "Password is required";
    }

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        // Use prepared statement
        $stmt = mysqli_prepare($con, "SELECT user_id, password FROM webdata WHERE user_name = ? LIMIT 1");
        mysqli_stmt_bind_param($stmt, "s", $user_name);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $user_id, $hashed_password_db);
            mysqli_stmt_fetch($stmt);

            $hashed_password_input = hash('sha256', $password);

            if ($hashed_password_db === $hashed_password_input) {
                $_SESSION['user_id'] = $user_id;
                header("Location: index.php");
                die;
            }
        }

        $error_password = "Incorrect credentials";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="logina.css">
	<link href='https://fonts.googleapis.com/css?family=Fira Code' rel='stylesheet'>
</head>

<body>
	<div class="box">
		<div class="logo">
		<img src="cube.png">
	</div>
		<div class="text2">
			<p>Cube Library Login</p>
		</div>
		<form method="post">

			<div class="error"><?php echo !empty($error_password) ? $error_password : $error_user_name; ?></div>
			
			<h3>Username</h3>
			<input id="text" type="text" name="user_name" placeholder="">
			<h3>Password</h3>
			<input id="text" type="password" name="password" placeholder=""><br><br>
			<div class="button1">
			<input id="button" type="submit" value="Login"><br><br>
			</div>
			<div class="signuptext">
			<a href="signup.php">Click to Signup</a><br><br>
		</div>
		</form>
	</div>
</body>

<style type="text/css">
	html{
min-height: 100%;
display: grid;
}

body{
	 font-family: 'Fira Code';
	background-color: #ECEEF0;
margin: auto;
}

.logo{

margin: -30px 0px 0px 47px;
}

.box {
	border-width: 200px;
	background-color: white;
	margin: 50px;
	padding: 50px 90px 90px 90px;
	align-content: center;
box-shadow: rgba(17, 17, 26, 0.1) 0px 4px 16px, rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px;}

.box #text{
	  width: 86%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
  margin-bottom: 10px;
}

.text2{
font-weight:700;
font-size: 23px;
}

p {
margin: 0px 0px 40px 0px;
}

.error {
font-size: 20px;
 color: #ff6666;
  width: 97%;
margin: 0% 0% 10% 0% ;
}


h3{
	margin-top: 0px;
	margin-bottom: 10px;
	font-size: 20px;
}

.box #button{
  position: relative;
  background-color: #4CAF50;
  border: none;
  font-size: 18px;
  color: #FFFFFF;
  padding: 10px;
  width: 240px;
  text-align: center;
  transition-duration: 0.4s;
  text-decoration: none;
  overflow: hidden;
  cursor: pointer;
}

.signuptext {
margin: 10px 4px 0 0; 
float: right;
}

</style>
</html>


<!--10.2 
 1. fixed login design
 2. now displays errors in login (username,pass required)
 3. now checks if username is already taken or not
 4. now both login and signup forms displays errors 
 -->


<!-- 10.4 
1.now hashes the passwords and verifies it via sha256
2.fixed signup sometimes not working error
3.fixed database mistake made by me XD
4.now displays mysql database errors
5.user_id is now unrepeatable
6.used prepared statements hopefully less vulnerable to sql inj


-->

