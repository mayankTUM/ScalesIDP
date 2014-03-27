<?php
$values = $_GET['q'];
$con = mysqli_connect('localhost','root','','my_wiki');
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$result = mysqli_query($con,'select * from smw_object_ids where smw_title = "'.$values.'"');
$scale_id = -1;
$scaleExists = false;
while($row = mysqli_fetch_array($result))
{
    $scale_id = $row['smw_id'];
    $result1 = mysqli_query($con,'select * from smw_di_wikipage where s_id = "'.$scale_id.'"');
    if(mysqli_num_rows($result1)!=0)
    {
	$scaleExists = true;
	break;
    } 
}
if($scaleExists)
{
    echo "true";
}
else
{
    echo "false";	
}
mysqli_close($con);
?>


