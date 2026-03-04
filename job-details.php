<?php
session_start();
include "config/db.php";

$job_id = $_GET['id'];

$sql = "SELECT jobs.*, users.company_name 
        FROM jobs 
        JOIN users ON jobs.employer_id = users.id
        WHERE jobs.id = '$job_id'";

$result = mysqli_query($conn,$sql);
$job = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $job['title']; ?></title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="container">

<h2><?php echo $job['title']; ?></h2>

<p class="company"><?php echo $job['company_name']; ?></p>

<p><strong>Location:</strong> <?php echo $job['location']; ?></p>

<p><strong>Salary:</strong> <?php echo $job['salary']; ?></p>

<br>

<h3>Job Description</h3>

<p><?php echo $job['description']; ?></p>

<br>

<a class="btn" href="apply.php?job_id=<?php echo $job['id']; ?>">
Apply Now
</a>

</div>

<footer style="text-align:center;margin-top:40px;padding:20px;color:#777">
© 2026 JobBoard. All rights reserved.
</footer>

</body>
</html>