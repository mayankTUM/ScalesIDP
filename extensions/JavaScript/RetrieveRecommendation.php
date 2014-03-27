<?php

$values = $_GET['q'];
$con = mysqli_connect('localhost','root','','my_wiki');

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}


$select_query = "SELECT * from scaleRecommendation where ScaleName1 = " . "'" . $values . "' or ScaleName2 = " . "'" . $values . "' order by Count desc"; 
//$select_query = "SELECT * from scaleRecommendation where ScaleName1 = 'Scale A' or ScaleName2 = 'Scale A' order by Count desc"; 
$result = mysqli_query($con,$select_query);
$count = 0;
$strToSend = "";
while($row = mysqli_fetch_array($result) and $count <3)
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
