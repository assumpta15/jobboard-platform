<?php
session_start();
include "config/db.php";

$success = "";

if(isset($_POST['register'])){

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];
$company = $_POST['company_name'];

$sql = "INSERT INTO users (name,email,password,role,company_name)
VALUES ('$name','$email','$password','$role','$company')";

if(mysqli_query($conn,$sql)){

$success = "Registration successful! Redirecting to login...";

echo "<script>
setTimeout(function(){
window.location.href='login.php';
},2000);
</script>";

}else{
$success = "Something went wrong. Please try again.";
}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="form-box">

<h2>Create Account</h2>

<?php
if($success != ""){
echo "<div class='success-msg'>$success</div>";
}
?>

<form method="POST">

<input type="text" name="name" placeholder="Full Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="text" name="company_name" placeholder="Company Name">

<input type="password" name="password" placeholder="Password" required>

<select name="role">
<option value="seeker">Job Seeker</option>
<option value="employer">Employer</option>
</select>

<button class="btn" name="register">Register</button>

<p class="auth-link">
Already have an account? 
<a href="login.php">Login</a>
</p>

</form>

</div>

<footer style="text-align:center;margin-top:40px;padding:20px;color:#777">
© 2026 JobBoard. All rights reserved.
</footer>

</body>
</html>