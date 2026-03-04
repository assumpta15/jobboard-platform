<?php
session_start();
include "config/db.php";

$error = "";

if(isset($_POST['login'])){

$email = mysqli_real_escape_string($conn,$_POST['email']);
$password = $_POST['password'];

if(empty($email) || empty($password)){
$error = "Please fill all fields.";
}else{

$sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) == 1){

$user = mysqli_fetch_assoc($result);

if(password_verify($password,$user['password'])){

$_SESSION['user_id'] = $user['id'];
$_SESSION['name'] = $user['name'];
$_SESSION['role'] = $user['role'];

if($user['role'] == "employer"){
header("Location: employer/dashboard.php");
}else{
header("Location: seeker/dashboard.php");
}

exit();

}else{
$error = "Incorrect password.";
}

}else{
$error = "Account not found.";
}

}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="form-box">

<h2>Login</h2>

<?php
if($error){
echo "<p class='error-msg'>$error</p>";
}
?>

<form method="POST">

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button class="btn" name="login">Login</button>

<p class="auth-link">
Don't have an account? 
<a href="register.php">Register</a>
</p>

</form>

</div>

<footer class="footer">
© 2026 JobBoard. All rights reserved.
</footer>

</body>
</html>