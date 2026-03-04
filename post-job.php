<?php
session_start();
include "config/db.php";

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

if(isset($_POST['post_job'])){

$title = $_POST['title'];
$description = $_POST['description'];
$location = $_POST['location'];
$salary = $_POST['salary'];
$employer_id = $_SESSION['user_id'];

$sql = "INSERT INTO jobs (title,description,location,salary,employer_id)
VALUES ('$title','$description','$location','$salary','$employer_id')";


if(mysqli_query($conn,$sql)){

header("Location: employer/dashboard.php?posted=success");
exit();

}else{
echo "Error posting job.";
}
}


?>

<!DOCTYPE html>
<html>
<head>
<title>Post Job</title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="form-box">

<h2>Post a Job</h2>

<?php
if(isset($message)){
echo "<p class='success-msg'>$message</p>";
}
?>

<form method="POST">

<label>Job Title</label>
<input type="text" name="title" required>

<label>Job Description</label>
<textarea name="description" required></textarea>

<label>Location</label>
<input type="text" name="location" required>

<label>Salary</label>
<input type="text" name="salary">

<button class="btn" name="post_job">Post Job</button>

</form>

</div>

<footer class="footer">
© 2026 JobBoard. All rights reserved.
</footer>

</body>
</html>