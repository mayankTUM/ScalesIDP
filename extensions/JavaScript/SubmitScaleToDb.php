<?php

$values = explode(",",$_GET['q']);
$con = mysqli_connect('localhost','root','','my_wiki');
$flag = false;

if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

//$insert_query = "INSERT INTO scaleQuestionsTest values(DEFAULT," . "'" . $values[0] . "','" . $values[1] . "','" . $values[2] . "'," . (int)$values[3] . "," .  (int)$values[4] . "," . (int)$values[5] . ",'" . $values[6] . "','" . $values[7] . "'," . (int)$values[8] . ",'" . $values[9] . "','" . $values[10] . "','" . $values[11] . "','" . $values[12] . "','" . $values[13] . "')";

$insert_query = "INSERT INTO scaleQuestionsTest values(DEFAULT,";

if($values[0]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . "'" . $values[0] . "',";
}

if($values[1]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . "'" . $values[1] . "',";
}

if($values[2]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . "'" . $values[2] . "',";
}

if($values[3]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . (int)$values[3] . ",";
}

if($values[4]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . (int)$values[4] . ",";
}

if($values[5]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . (int)$values[5] . ",";
}

if($values[6]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . "'" . $values[6] . "',";
}

if($values[7]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . "'" . $values[7] . "',";
}

if($values[8]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . (int)$values[8] . ",";
}

if($values[9]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . "'" . $values[9] . "',";
}
if($values[10]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . "'" . $values[10] . "',";
}
if($values[11]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . "'" . $values[11] . "',";
}
if($values[12]==""){
$insert_query = $insert_query . "NULL,";
} else {
$insert_query = $insert_query . "'" . $values[12] . "',";
}
if($values[13]==""){
$insert_query = $insert_query . "NULL)";
} else {
$insert_query = $insert_query . "'" . $values[13] . "')";
}

mysqli_query($con,$insert_query);

mysqli_close($con);
?>
