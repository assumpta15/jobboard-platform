<?php
include "config/db.php";

$id = $_GET['id'];

$sql = "SELECT * FROM jobs WHERE id='$id'";
$result = mysqli_query($conn,$sql);

$job = mysqli_fetch_assoc($result);
?>

<h2><?php echo $job['title']; ?></h2>

<p><?php echo $job['description']; ?></p>

<p>Location: <?php echo $job['location']; ?></p>

<p>Salary: <?php echo $job['salary']; ?></p>

<a href="apply.php?job_id=<?php echo $job['id']; ?>">Apply Now</a>




<footer style="text-align:center;margin-top:40px;padding:20px;color:#777">

© 2026 JobBoard. All rights reserved.

</footer>