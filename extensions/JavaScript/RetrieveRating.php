<?php

$values = $_GET['q'];
$con = mysqli_connect('localhost','root','','my_wiki');

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$select_query = "SELECT * from scaleRating where ScaleName = " . "'".$values."'"; 
$result = mysqli_query($con,$select_query);
$rating = -1.0;
while($row = mysqli_fetch_array($result))
{
   $rating = $row['Rating'];
}

echo $rating;

mysqli_close($con);
?>