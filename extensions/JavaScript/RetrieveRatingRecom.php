<?php

$values = $_GET['q'];
$con = mysqli_connect('localhost','root','','my_wiki');

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$select_query1 = "SELECT * from scaleRating where ScaleName = " . "'".$values."'"; 
$select_query2 = "SELECT * from scaleRecommendation where ScaleName1 = " . "'" . $values . "' or ScaleName2 = " . "'" . $values . "' order by Count desc"; 

$result1 = mysqli_query($con,$select_query1);
$result2 = mysqli_query($con,$select_query2);

$count = 0;
$strToSend = "";

$rating = -1.0;
while($row = mysqli_fetch_array($result1))
{
   $rating = $row['Rating'];
}

$strToSend .= $rating;
$strToSend .= '|';

while($row = mysqli_fetch_array($result2) and $count <3)
{
   $scale1 = $row['ScaleName1'];
   $scale2 = $row['ScaleName2'];
   if($scale1==$values) {
    $strToSend .= $scale2 . ",";
   } else {
    $strToSend .= $scale1 . ",";
   }
   $count++;
}

echo $strToSend;

mysqli_close($con);
?>
