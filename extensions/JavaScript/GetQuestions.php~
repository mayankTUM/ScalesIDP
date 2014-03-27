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
    echo $row['InitQuestion'] . "," . $row['NumberOfItems']  . "," . $row['Questions']; 
}
mysqli_close($con);
?>


