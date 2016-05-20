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
$nn="username";
$data=array();
$s="select DISTINCT username from users where  username LIKE'%$q%'";
if($d=="Email")
{
	$s="select DISTINCT email from users where  email LIKE'%$q%'";
	$nn="email";
}
else if($d=="Username")
{
	$s="select DISTINCT username from users where  username LIKE'%$q%'";
	$nn="username";
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
	$s="select DISTINCT email from users where  email LIKE'%$q%'";
	$nn="email";
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