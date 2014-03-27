<?php
$con=mysqli_connect("127.0.0.1","root","","my_wiki");
// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

$sql="CREATE TABLE journals(Rank INT,Name CHAR(100),Rating CHAR(10),JQ2 DOUBLE)";

if (mysqli_query($con,$sql))
  {
  echo "Table journals created successfully";
  }
else
  {
  echo "Error creating table: " . mysqli_error($con);
  }

$handle = fopen("Journals.csv", "r");
if ($handle) {
    $line = fgets($handle);	
    while (($line = fgets($handle)) !== false) {
	$pieces = explode(",", $line);        
	mysqli_query($con,"INSERT INTO journals (Rank, Name, Rating, JQ2) VALUES (".intval($pieces[0]).",'".$pieces[1]."','".$pieces[2]."',".doubleval($pieces[3]).")");
	}
} else {
    // error opening the file.
    echo "some error";
}

mysqli_close($con);

?>

