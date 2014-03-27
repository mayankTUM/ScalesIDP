<?php
$values = $_GET['q'];
$con = mysqli_connect('localhost','root','','my_wiki');
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con,'select * from scaleQuestionsTest where ScaleName = "'.$values.'"');

while($row = mysqli_fetch_array($result))
{
    echo $row['Questions'].",". $row['InitQuestion'].",".$row['NumberOfItems'].",".$row['From_Likert'].",". $row['To_Likert'].",".$row['Lowest'].",". $row['Highest'].",".$row['NumberOfPoints'].",".$row['From_Qsort'].",". $row['To_Qsort'].",".$row['OrderLogic'].",". $row['Explanation'].",". $row['ScaleType'];
}
mysqli_close($con);
?>

