<?php

include "config/db.php";

$job_id = $_GET['job_id'];

$sql = "SELECT applications.*, users.name
FROM applications
JOIN users ON applications.seeker_id = users.id
WHERE job_id='$job_id'";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){

echo "<p>".$row['name']."</p>";
echo "<a href='uploads/".$row['cv']."' download>Download CV</a>";
echo "<hr>";

}



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <footer style="text-align:center;margin-top:40px;padding:20px;color:#777">

© 2026 JobBoard. All rights reserved.

</footer>
</body>
</html>


<?