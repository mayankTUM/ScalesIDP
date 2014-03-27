<?php

$values = explode(",",$_GET['q']);
$con = mysqli_connect('localhost','root','','my_wiki');
$flag = false;

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "CREATE TABLE scaleRating (ScaleName CHAR(100),Rating DOUBLE,Count INT)";

try
{
 mysqli_query($con,$sql);
 echo "Table workTest created successfully";
}
catch(Exception $e)
{
 echo "Table already exists: " . $e->getMessage();
}

$select_query = "SELECT * from scaleRating where ScaleName = " . "'".$values[0]."'"; 
$result = mysqli_query($con,$select_query);
$count = 0;
$rating = 0.0;
while($row = mysqli_fetch_array($result))
{
   $flag=true;
   $count = $row['Count'];
   $rating = $row['Rating'];
}

if($flag)
{
 $average_rating = ($rating * $count + $values[1]) / ($count + 1);
 $insert = "UPDATE scaleRating SET Count = ". ($count+1) . ", Rating = " . $average_rating . " WHERE ScaleName = '". $values[0] ."'";
 mysqli_query($con,$insert);
}
else
{
  $init_count = 1;
  $insert = "INSERT INTO scaleRating (ScaleName, Rating, Count) VALUES ("."'".$values[0]."'".",".doubleval($values[1]).",".$init_count.")";
  mysqli_query($con,$insert);
}

mysqli_close($con);
?>
