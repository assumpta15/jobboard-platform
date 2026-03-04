<?php

session_start();
include "config/db.php";

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

if(!isset($_GET['job_id'])){
echo "Invalid job.";
exit();
}

$job_id = $_GET['job_id'];
$seeker_id = $_SESSION['user_id'];

if(isset($_POST['apply'])){

$cover_letter = $_POST['cover_letter'];
$linkedin = $_POST['linkedin'];

$cv = $_FILES['cv']['name'];
$tmp = $_FILES['cv']['tmp_name'];

# create unique file name
$cv_name = time() . "_" . $cv;

$upload_dir = __DIR__ . "/uploads/";
$folder = $upload_dir . $cv_name;

# prevent duplicate applications
$check = "SELECT * FROM applications 
WHERE job_id='$job_id' AND seeker_id='$seeker_id'";

$res = mysqli_query($conn,$check);

if(mysqli_num_rows($res) > 0){

echo "<div class='error-msg'>You already applied for this job.</div>";

}else{

move_uploaded_file($tmp, $folder);

$sql = "INSERT INTO applications 
(job_id,seeker_id,cv,cover_letter,linkedin,status)
VALUES 
('$job_id','$seeker_id','$cv_name','$cover_letter','$linkedin','pending')";

if(mysqli_query($conn,$sql)){

echo "<div class='success-msg'>
Application submitted successfully.<br>
Redirecting to your dashboard...
</div>";

echo "<script>
setTimeout(function(){
window.location.href = 'seeker/dashboard.php';
},2000);
</script>";

}else{

echo "<div class='error-msg'>Error submitting application</div>";

}

}

}

?>

<!DOCTYPE html>
<html>
<head>
<title>Apply for Job</title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="form-box">

<h2>Apply for Job</h2>

<form method="POST" enctype="multipart/form-data">

<label>Upload CV</label>
<input type="file" name="cv" required>

<label>Cover Letter</label>
<textarea name="cover_letter" placeholder="Write a short cover letter"></textarea>

<label>LinkedIn Profile</label>
<input type="text" name="linkedin" placeholder="https://linkedin.com/in/username">

<button class="btn" name="apply">Submit Application</button>

</form>

</div>

<footer class="footer">
© 2026 JobBoard. All rights reserved.
</footer>

</body>
</html>