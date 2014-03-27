<?php

$values = explode(",",$_GET['q']);
$parentName = $values[0];
$childName = $values[1];

//$parentName = "Scale C";
//$childName = "Scale D";


$con=mysqli_connect("127.0.0.1","root","","my_wiki");
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$sql = "CREATE TABLE parentChildRelationship (grandParent VARCHAR(255),parent VARCHAR(255) NOT NULL PRIMARY KEY,children VARCHAR(255))";
try
{
 mysqli_query($con,$sql);
 echo "Table workTest created successfully";
}
catch(Exception $e)
{
 echo "Table already exists: " . $e->getMessage();
}

$checkRowExistence = "SELECT * FROM parentChildRelationship where grandParent = '".$parentName."' and parent = '".$childName."'";
$result1 = mysqli_query($con,$checkRowExistence);
if(mysqli_num_rows($result1) == 0)
{
   $queryToInsertScale = "INSERT INTO parentChildRelationship(grandParent,parent) values ('".$parentName."','".$childName."')";
   mysqli_query($con,$queryToInsertScale);
   $checkChildrenExistence = "SELECT * FROM parentChildRelationship where parent = '".$parentName."'";
   $result2 = mysqli_query($con,$checkChildrenExistence);
   if(mysqli_num_rows($result2)==0)
   {
      $insertRow = "INSERT INTO parentChildRelationship(parent,children) values('".$parentName."','".$childName."')";
      mysqli_query($con,$insertRow);
   }
   else
   {
    while($row=mysqli_fetch_array($result2))
    {
      $children = $row['children'];
      if($children != NULL)
      {
         $childrenList = $children.",".$childName;
         $insertChildren = "UPDATE parentChildRelationship set children = '".$childrenList."' where parent = '".$parentName."'";
         mysqli_query($con,$insertChildren);
      } 
      else
      {
         $childrenList = $childName;
         $insertChildren = "UPDATE parentChildRelationship set children = '".$childrenList."' where parent = '".$parentName."'";
         mysqli_query($con,$insertChildren);
      } 
    }
   }
}

mysqli_close($con);
?>
