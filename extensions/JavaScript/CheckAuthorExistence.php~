<?php
$values = $_GET['q'];
$values_with_underscores = str_ireplace(" ","_",$values);
$con = mysqli_connect('localhost','root','','my_wiki');
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$result1 = mysqli_query($con,'select * from smw_object_ids where smw_title = "Author"');
$author_prop_id =-1;
$authorPropFound = false;
while($row = mysqli_fetch_array($result1))
{
    $author_prop_id = $row['smw_id'];
    $result2 = mysqli_query($con,'select * from smw_di_wikipage where p_id = '.$author_prop_id);  
    if(mysqli_num_rows($result2)!=0)
    {
	$authorPropFound = true;
        break;
    }
}
$authorFound = false;
$author_id =-1;
$result3 = mysqli_query($con,'select * from smw_object_ids where smw_title = "'.$values.'" or smw_title = "'.$values_with_underscores.'"');
if($authorPropFound)
{
  while($row = mysqli_fetch_array($result3))
  {
    $author_id = $row['smw_id'];
    $result4 = mysqli_query($con,'select * from smw_di_wikipage where p_id = '.$author_prop_id.' and o_id = '.$author_id); 
    if(mysqli_num_rows($result4) != 0)
    {
        $authorFound = true;
        break;
    }
  }
}

if($authorPropFound == TRUE && $authorFound === TRUE)
{
  echo "true";
}
else
{
  echo "false";
}

mysqli_close($con);
?>

