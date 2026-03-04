<?php
session_start();
include "../config/db.php";

/* Protect page */
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'employer'){
header("Location: ../login.php");
exit();
}

$user_id = $_SESSION['user_id'];

/* Get jobs posted */
$sql = "SELECT * FROM jobs WHERE employer_id='$user_id'";
$result = mysqli_query($conn,$sql);

/* Count applications */
$sql1 = "SELECT COUNT(*) as total FROM applications
JOIN jobs ON applications.job_id = jobs.id
WHERE jobs.employer_id='$user_id'";

$res1 = mysqli_query($conn,$sql1);
$applications = mysqli_fetch_assoc($res1)['total'];

/* Count jobs */
$sql2 = "SELECT COUNT(*) as total FROM jobs WHERE employer_id='$user_id'";
$res2 = mysqli_query($conn,$sql2);
$count = mysqli_fetch_assoc($res2)['total'];

/* Get applications */
$app_sql = "SELECT applications.*, jobs.title, users.name, users.email
FROM applications
JOIN jobs ON applications.job_id = jobs.id
JOIN users ON applications.seeker_id = users.id
WHERE jobs.employer_id='$user_id'
ORDER BY applications.id DESC";

$app_result = mysqli_query($conn,$app_sql);
?>

<!DOCTYPE html>
<html>
<head>
<title>Employer Dashboard</title>
<link rel="stylesheet" href="../assets/style.css">
</head>

<body>

<div class="container">

<h2>Employer Dashboard</h2>

<?php
if(isset($_GET['status'])){
echo "<p class='success-msg'>Application status updated successfully.</p>";
}

if(isset($_GET['posted'])){
echo "<p class='success-msg'>Job posted successfully!</p>";
}
?>

<a href="../post-job.php" class="btn">Post New Job</a>

<br><br>

<h3>Your Posted Jobs</h3>

<?php
while($job = mysqli_fetch_assoc($result)){
?>

<div class="job-card">

<div class="job-info">

<h3><?php echo $job['title']; ?></h3>

<p><?php echo $job['description']; ?></p>

<p><strong>Location:</strong> <?php echo $job['location']; ?></p>

<p><strong>Salary:</strong> <?php echo $job['salary']; ?></p>

</div>

</div>

<?php } ?>

<br>

<h3>Dashboard Overview</h3>

<div class="stat-card blue">
<?php echo $applications ?> Applications
</div>

<div class="stat-card green">
<?php echo $count ?> Jobs Posted
</div>

<div class="stat-card orange">
Interviews
</div>

<br>

<h3>Applications Received</h3>

<?php
while($app = mysqli_fetch_assoc($app_result)){
?>

<div class="job-card">

<div class="job-info">

<h4><?php echo $app['title']; ?></h4>

<p><strong>Applicant:</strong> <?php echo $app['name']; ?></p>

<p><strong>Email:</strong> <?php echo $app['email']; ?></p>

<p><strong>Status:</strong> <?php echo ucfirst($app['status']); ?></p>

</div>

<div>

<a href="../uploads/<?php echo $app['cv']; ?>" class="action-btn" download>
Download CV
</a>

<br><br>

<a href="../update-status.php?id=<?php echo $app['id']; ?>&status=accepted" class="action-btn">
Accept
</a>

<a href="../update-status.php?id=<?php echo $app['id']; ?>&status=rejected" class="action-btn">
Reject
</a>

</div>

</div>

<?php } ?>

<br>

<a href="../logout.php" class="logout-btn">Logout</a>

<footer class="footer">
© 2026 JobBoard. All rights reserved.
</footer>

</div>

</body>
</html>