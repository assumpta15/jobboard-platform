<?php

include "config/db.php";

$id = $_GET['id'];
$status = $_GET['status'];

$sql = "UPDATE applications SET status='$status' WHERE id='$id'";

if(mysqli_query($conn,$sql)){

header("Location: employer/dashboard.php?status=updated");
exit();

}else{

echo "Error updating status";

}


$email_sql = "SELECT users.email, jobs.title 
FROM applications
JOIN users ON applications.seeker_id = users.id
JOIN jobs ON applications.job_id = jobs.id
WHERE applications.id='$id'";

$res = mysqli_query($conn,$email_sql);
$data = mysqli_fetch_assoc($res);

$email = $data['email'];
$job = $data['title'];

$message = "Your application for $job has been $status.";

mail($email,"Application Update",$message);