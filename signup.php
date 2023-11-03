<?php
session_start();

include("connection.php");

$error_user_name_taken = "";
$error_fill = "";

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = addslashes($_POST['user_name']);
    $password = addslashes($_POST['password']);

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {

        $query = "SELECT * FROM webdata WHERE user_name = '$user_name'";
        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $error_user_name_taken = "Username is taken";
        } else {
            $user_id = random_num(5);

            $hashed_password = hash('sha256', $password);

            $query = "INSERT INTO webdata (user_id, user_name, password) VALUES ('$user_id', '$user_name', '$hashed_password')";
            
            if (mysqli_query($con, $query)) {
                header("Location: login.php");
                die;
            } else {
                echo "Error: " . mysqli_error($con);
            }
        }
    } else {
        $error_fill = "Enter valid inputs";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
</head>
<body>
	
<div class="box">
		<div class="logo">
		<img src="cube.png">
	</div>
		<div class="text2">
			<p>Cube Library Signup</p>
		</div>
		<form method="post">

           <div class="error_taken"><?php echo !empty($error_user_name_taken) ? $error_user_name_taken : $error_fill; ?></div>
			<h3>Username</h3>
			<input id="text" type="text" name="user_name" placeholder="">
			<h3>Password</h3>
			<input id="text" type="password" name="password" placeholder=""><br><br>
			<div class="button1">
			<input id="button" type="submit" value="Signup"><br><br>
			</div>
			<div class="signuptext">
			<a href="login.php">Click to Login</a><br><br>
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

.error_taken {
font-size: 21px;
 color: #ff6666;
  width: 97%;
margin: 0% 0% 10% 6% ;
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
  width: 251px;
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