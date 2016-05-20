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
$s="select DISTINCT name from medicines where  name LIKE'%$q%'";
if($d=="Disease")
{
	$s="select DISTINCT ctgry from medicines where  ctgry LIKE'%$q%'";
	$nn="ctgry";
}
else if($d=="Medicine")
{
	$s="select DISTINCT name from medicines where  name LIKE'%$q%'";
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
	$s="select DISTINCT ctgry from medicines where  ctgry LIKE'%$q%'";
	$nn="ctgry";
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