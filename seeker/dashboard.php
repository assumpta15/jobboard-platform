<?php
session_start();
include "../config/db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'seeker'){
header("Location: ../login.php");
exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT applications.*, jobs.title, jobs.location, jobs.salary
FROM applications
JOIN jobs ON applications.job_id = jobs.id
WHERE applications.seeker_id = '$user_id'
ORDER BY applications.id DESC";

$result = mysqli_query($conn,$sql);
?>


<!DOCTYPE html>
<html>
<head>
<title>My Applications</title>
<link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="navbar">

<div class="logo">JobBoard</div>

<div class="nav-links">
<a href="../index.php">Jobs</a>
<a href="dashboard.php">My Applications</a>
<a href="../logout.php">Logout</a>
</div>

</div>


<div class="container">

<h2>My Applications</h2>

<p class="welcome">
Welcome, <?php echo $_SESSION['name']; ?>
</p>

<?php

if(mysqli_num_rows($result) > 0){

while($row = mysqli_fetch_assoc($result)){

?>

<div class="job-card">

<div class="job-info">

<h3><?php echo $row['title']; ?></h3>

<p><strong>Location:</strong> <?php echo $row['location']; ?></p>

<p><strong>Salary:</strong> <?php echo $row['salary']; ?></p>

<p class="status">
Status: <?php echo ucfirst($row['status']); ?>
</p>

</div>

</div>

<?php

}

}else{

?>

<div class="empty-state">

<h3>No Applications Yet</h3>

<p>You haven't applied to any jobs yet.</p>

<a href="../index.php" class="btn primary-btn">Browse Jobs</a>

</div>

<?php } ?>


<footer class="footer">

© 2026 JobBoard. All rights reserved.

</footer>

</div>

</body>
</html>