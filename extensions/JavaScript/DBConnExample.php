<?php

$values = explode(",",$_GET['q']);
$con = mysqli_connect('localhost','root','','my_wiki');

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "CREATE TABLE workTest (Author CHAR(100),University CHAR(100),TypeOfWork CHAR(10))";

try
{
 mysqli_query($con,$sql);
 echo "Table workTest created successfully";
}
catch(Exception $e)
{
 echo "Table already exists: " . $e->getMessage();
}

if(mysqli_query($con,"INSERT INTO workTest (Author, University, TypeOfWork) VALUES ("."'".$values[0]."'".","."'".$values[1]."'".","."'".$values[2]."'".")"))
{
 echo "Row inserted successfully";
}
else
{
 echo "Error inserting in row";
}

mysqli_close($con);
?>
