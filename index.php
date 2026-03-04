<?php
session_start();
include "config/db.php";

$applications = 0;
$interviews = 0;

if(isset($_SESSION['user_id']) && $_SESSION['role'] == "seeker"){

$user = $_SESSION['user_id'];

$sql = "SELECT COUNT(*) as total FROM applications WHERE seeker_id='$user'";
$res = mysqli_query($conn,$sql);
$applications = mysqli_fetch_assoc($res)['total'];

$sql2 = "SELECT COUNT(*) as total FROM applications 
WHERE seeker_id='$user' AND status='accepted'";
$res2 = mysqli_query($conn,$sql2);
$interviews = mysqli_fetch_assoc($res2)['total'];

}
?>

<!DOCTYPE html>
<html>
<head>
<title>JobBoard</title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>


<!-- NAVBAR -->
<div class="navbar">

<div class="logo">JobBoard</div>

<div class="nav-links">

<?php if(isset($_SESSION['name'])){ ?>
<span class="welcome-text">Welcome, <?php echo $_SESSION['name']; ?> 👋</span>
<?php } ?>

<a href="/jobboard/index.php">Jobs</a>

<?php if(isset($_SESSION['role']) && $_SESSION['role']=="employer"){ ?>
<a href="/jobboard/employer/dashboard.php">Employer Dashboard</a>
<?php } ?>

<?php if(isset($_SESSION['role']) && $_SESSION['role']=="seeker"){ ?>
<a href="/jobboard/seeker/dashboard.php">My Applications</a>
<?php } ?>

<?php if(isset($_SESSION['user_id'])){ ?>
<a href="/jobboard/logout.php">Logout</a>
<?php } else { ?>
<a href="/jobboard/login.php">Login</a>
<?php } ?>

</div>

</div>



<!-- SEARCH BAR -->
<div class="search-section">

<form method="GET" class="search-bar">

<input 
type="text" 
name="search" 
placeholder="Job title, keywords, or company"
>

<select name="category">
<option value="">Category</option>
<option value="development">Development</option>
<option value="marketing">Marketing</option>
<option value="design">Design</option>
</select>

<input 
type="text" 
name="location" 
placeholder="Location"
>

<button type="submit">Find Jobs</button>

</form>

</div>



<div class="container">

<h1>Latest Job Listings</h1>

<div class="main-layout">


<!-- JOB LIST -->
<div class="jobs">

<?php

$sql = "SELECT jobs.*, users.company_name 
FROM jobs 
JOIN users ON jobs.employer_id = users.id
ORDER BY jobs.created_at DESC";

$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0){

while($job = mysqli_fetch_assoc($result)){
?>

<div class="job-card">

<div class="job-left">

<h3>
<a href="job-details.php?id=<?php echo $job['id']; ?>">
<?php echo $job['title']; ?>
</a>
</h3>

<p class="company-name">
🏢 <?php echo $job['company_name']; ?>
</p>

<p><?php echo $job['description']; ?></p>

<p><strong>Location:</strong> <?php echo $job['location']; ?></p>

<p><strong>Salary:</strong> <?php echo $job['salary']; ?></p>

</div>

<div class="job-right">

<a href="apply.php?job_id=<?php echo $job['id']; ?>" class="apply-btn">
Apply Now
</a>

</div>

</div>

<?php
}

}else{

echo "<p>No jobs available</p>";

}
?>

</div>



<!-- RIGHT DASHBOARD -->
<div class="stats">

<h3>Dashboard Overview</h3>

<div class="stat-card blue">
<?php echo $applications ?> Applications
</div>

<div class="stat-card green">
Jobs Saved
</div>

<div class="stat-card orange">
<?php echo $interviews ?> Interviews
</div>

</div>


</div>

</div>


<footer style="text-align:center;margin-top:40px;padding:20px;color:#777">
© 2026 JobBoard. All rights reserved.
</footer>

</body>
</html>