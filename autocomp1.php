<?php
$servername = "localhost";
$user = "root";			
$password = "";
$dbname = "helphand";

// Create connection	
$conn = new mysqli($servername, $user, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$q=$_GET['term'];
$d=$_GET['typee'];
$nn="name";
$data=array();
$s="select DISTINCT name from doctors where  name LIKE'%$q%'";
if($d=="Specialty")
{
	$s="select DISTINCT expertise from doctors where  expertise LIKE'%$q%'";
	$nn="expertise";
}
else if($d=="Name")
{
	$s="select DISTINCT name from doctors where  name LIKE'%$q%'";
	$nn="name";
}
else
{
	$result = $conn->query($s);
	if ($result->num_rows!=0) 
	{
		while($row = $result->fetch_assoc())
		{ 
			array_push($data,$row[$nn]);
		}
	}
	$s="select DISTINCT expertise from doctors where  expertise LIKE'%$q%'";
	$nn="expertise";
}
$result = $conn->query($s);
if ($result->num_rows!=0) 
{
	while($row = $result->fetch_assoc())
	{ 
		array_push($data,$row[$nn]);
	}
}
echo json_encode($data);
?>