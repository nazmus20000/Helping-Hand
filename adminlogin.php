<?php
	ob_start();
	session_start();
?>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Helping Hand</title>
		<link rel="stylesheet" href="css/style.css"/>
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
		<meta content="IE=edge" http-equiv="X-UA-Compatible">
		<meta content="" name="description">
		<meta content="" name="author">
		<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css"/>
		<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap-theme.min.css"/>
		<!-- Just for debugging purposes -->
		<script src="bootstrap-3.3.2-dist/js/ie-emulation-modes-warning.js"></script>
		<style type="text/css"> 
			body{
				padding-top:50px;
			}
			.bs-example{
				margin: 20px;
			}
			#error-container {
				 margin-top:100px;
				 position: fixed;
			}
		</style>
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
		?>
	</head>
	<body>
		<?php
		if(isset($_POST['email']))
		{
			$email=$_POST['email'];
			$pass=$_POST['password'];
			if ($email=="admin"&&$pass=="1") 
			{
				header('Location: adminapp.php');
			}
			else
				echo "bla";
		}
		?>
		<div class="container" style="margin-top:110px;">	
			<h2 style="color:#3eb4e5;text-align:center;">Admin Login</h2>
			<br><br>
			<form action="adminlogin.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
				<div class="form-group" style="margin-left:400px;">
					<input type="text" name="email" class="form-control" placeholder="Email" style="height:46px;width:350px">
				</div><br><br>
				<div class="form-group" style="margin-left:400px;">
					<input type="password" name="password" class="form-control" placeholder="Password"style="height:46px;width:350px">
				</div><br><br><br>
				<p style="text-align:center;"><input type="submit" class="btn btn-success" value="Log In" style="height:40px;width:80px"></p>
			</form>
		</div><!-- /.container -->
		<?php
			mysqli_close($conn);
			ob_end_flush();
		?>
		
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="bootstrap-3.3.2-dist/js/jquery.min.js"></script>
		<script src="bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
		<script src="bootstrap-3.3.2-dist/js/docs.min.js"></script>
		<script src="js/jquery-2.1.3.min.js"></script>
		<script src="js/myjs.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="bootstrap-3.3.2-dist/js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>