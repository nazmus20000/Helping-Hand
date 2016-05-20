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
		<script type="text/javascript">
			$(document).ready(function(){
				$(".close").click(function(){
					$("#myAlert").alert();
				});
			});
		</script>
		<script>
		  var loadFile = function(event) {
			var output = document.getElementById('output');
			output.src = URL.createObjectURL(event.target.files[0]);
		  };
		</script>
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
	<!--\\\\\\\\\\\\\Navigation ber starts here/////////////-->
		<?php
			function navi()
			{
		?>
				<ul class="nav navbar-nav">
					<li class="active"><a href="#" style="font-size:16px;">Home</a></li>
					<li><a href="doctor.php" style="font-size:16px;">Find a doctor</a></li>
					<li class="dropdown">
					<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" style="font-size:16px;">Doctor Accessories<span class="caret"></span></a>
					<ul role="menu" class="dropdown-menu">
						<li><a href="equipments.php" style="font-size:16px;">Equipements</a></li>
						<li><a href="medicines.php" style="font-size:16px;">Medicines</a></li>
					</ul>
					</li>
					<li><a href="blog.php" style="font-size:16px;">Blog</a></li>
					<li><a href="about.php" style="font-size:16px;">About</a></li>
					<li><a href="contact.php" style="font-size:16px;">Contact</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#" data-toggle="modal" data-target="#modal-1"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
										
					<li><a href="#" data-toggle="modal" data-target="#modal-2"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
				</ul>
		<?php
			}
		?>
		<div class="navbar-wrapper">
			<div class="container">
				<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
					<div class="container">
						<div class="navbar-header">
							<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
								<span class="sr-only">Toggle nevigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a href="#" class="navbar-brand" style="font-size:20px;">HelpingHand</a>
						</div>
						<div class="navbar-collapse collapse" id="navbar">
                    
					<!-- inside it we can put form, list etc anything we want -->
							<?php
								if(isset($_POST['email']))
								{
									$email=$_POST['email'];
									$pass=$_POST['password'];
									$s="select * from users where email=\"$email\" and password=\"$pass\"";
									$result = $conn->query($s);
									if ($result->num_rows!=0) 
									{
										$cur=1;
										if($row = $result->fetch_assoc())
										{ 
											$username=$row["username"];
											$type=$row["type"];
											$_SESSION["username"]=$username;
											$_SESSION["type"]=$type;
											$_SESSION["email"]=$email;
											$_SESSION["password"]=$pass;
											$s="select * from cart where email='".$_SESSION["email"]."'";
											$result = $conn->query($s);
											$cnt=0;
											if ($result->num_rows!=0) 
											{
												while($row = $result->fetch_assoc())
												{ 
													$cnt=$cnt+1;
												}
											}
											$s="select * from notification where rec='".$_SESSION["email"]."' and status=''";
											$result = $conn->query($s);
											$cnt1=0;
											if ($result->num_rows!=0) 
											{
												while($row = $result->fetch_assoc())
												{ 
													$cnt1=$cnt1+1;
												}
											}
							?>
											<ul class="nav navbar-nav">
												<li class="active"><a href="#" style="font-size:16px;">Home</a></li>
												<li><a href="doctor.php" style="font-size:16px;">Find a doctor</a></li>
												<?php 
													if($type=="doctor")
													{
												?>
														<li><a href="dpanel.php" style="font-size:16px;">Doctor Panel</a></li>
												<?php
													}
												?>
												<li class="dropdown">
													<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" style="font-size:16px;">Doctor Accessories<span class="caret"></span></a>
													<ul role="menu" class="dropdown-menu">
														<li><a href="equipments.php" style="font-size:16px;">Equipements</a></li>
														<li><a href="medicines.php" style="font-size:16px;">Medicines</a></li>
													</ul>
												</li>
												<li><a href="blog.php" style="font-size:16px;">Blog</a></li>
												<li><a href="about.php" style="font-size:16px;">About</a></li>
												<li><a href="contact.php" style="font-size:16px;">Contact</a></li>
											</ul>
											<ul class="nav navbar-nav navbar-right">
											<li><a href="cart.php" style="font-size:16px;"><span class="glyphicon glyphicon-shopping-cart"></span> Cart <span class="badge"style="font-size:12px;"><?php echo $cnt;?></span></a></li>
												
												<li><a href="notification.php" style="font-size:17px;"><span class="glyphicon glyphicon-globe" ></span> Notifications <span class="badge"style="font-size:12px;"><?php echo $cnt1;?></span></a></li>
												<li class="dropdown">
													<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" style="font-size:16px;"><?php echo $_SESSION["username"];?><span class="caret"></span></a>
													<ul role="menu" class="dropdown-menu">
														<p style="text-align:center;"><li><a href="profile.php" style="font-size:16px;text-align:center;">Profile</a></li></p>
														<!--<form method="post">
															<li><a href="index.php" style="font-size:16px;" name="logout" id="logout">Logout</a></li>
														</form>-->
														<li>
															<form action="index.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
																<p style="text-align:center;"><input name="logout" type="submit" class="btn btn-success" value="Sign Out"></p>
															</form>
														</li>
													</ul>
												</li>
											</ul>
							<?php
										}
									}
									else 
									{
										navi();
							?>
										
										<!-- ///////for wrong password\\\\\\\\
										<div class="container">
											<div class="row" id="error-container">
												 <div class="span12">  
													 <div class="alert alert-error">
														<button type="button" class="close" data-dismiss="alert">×</button>
														 test error message
													 </div>
												 </div>
											</div>
										</div>
										
										<div class="bs-example">
											<div class="alert alert-danger" id="myAlert">
												<a href="#" class="close" data-dismiss="alert">&times;</a>
												<strong>Error!</strong> A problem has been occurred while submitting your data.
											</div>
										</div>
										-->
							<?php
									}
								}
								else if(isset($_POST['logout']))
								{
									$s="select * from cart";
									$result = $conn->query($s);
									$i=0;
									$q=array();
									$med=array();
									if ($result->num_rows!=0) 
									{	
										while($row = $result->fetch_assoc())
										{
											$q[$i]=$row["quan"];
											$med[$i]=$row["med_id"];
											$i=$i+1;
										}
									}
									$sql = "DELETE FROM cart";
									mysqli_query($conn, $sql);
									for($j=0;$j<$i;$j++)
									{
										$s="select quan from medicines where med_id='$med[$j]'";
										$result = $conn->query($s);
										if ($result->num_rows!=0) 
										{	
											if($row = $result->fetch_assoc())
											{
												$quant=$q[$j]+$row["quan"];
												$sql = "UPDATE medicines SET quan=\"$quant\" WHERE med_id='$med[$j]'";
												$conn->query($sql);
											}
										}
									}
									// remove all session variables
									session_unset();

									// destroy the session
									session_destroy(); 
									navi();
									header('Location: index.php');
								}
								else  if(isset($_POST['regemail']))
								{
									$email=$_POST['regemail'];
									$username=$_POST['username'];
									if(isset($_POST['type']))
									{
										$type=$_POST['type'];
									}
									else $type="";
									$pass=$_POST['password'];
									$s="select * from users where email=\"$email\" OR username=\"$username\"";
									$result = $conn->query($s);
									if ($result->num_rows!=0||$type=="") 
									{
										navi();
									}
									else
									{
										$_SESSION["username"]=$username;
										$_SESSION["type"]=$type;
										$_SESSION["email"]=$email;
										$_SESSION["password"]=$pass;
										$s="INSERT INTO users (username,email,password,type) VALUES('$username','$email','$pass','$type')";
										$conn->query($s);
										$s="select * from cart where email='".$_SESSION["email"]."'";
										$result = $conn->query($s);
										$cnt=0;
										if ($result->num_rows!=0) 
										{
											while($row = $result->fetch_assoc())
											{ 
												$cnt=$cnt+1;
											}
										}
										$s="select * from notification where rec='".$_SESSION["email"]."' and status=''";
										$result = $conn->query($s);
										$cnt1=0;
										if ($result->num_rows!=0) 
										{
											while($row = $result->fetch_assoc())
											{ 
												$cnt1=$cnt1+1;
											}
										}
							?>				
										<ul class="nav navbar-nav">
												<li class="active"><a href="#" style="font-size:16px;">Home</a></li>
												<li><a href="doctor.php" style="font-size:16px;">Find a doctor</a></li>
												<?php 
													if($type=="doctor")
													{
												?>
														<li><a href="dpanel.php" style="font-size:16px;">Doctor Panel</a></li>
												<?php
													}
												?>
												<li class="dropdown">
													<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" style="font-size:16px;">Doctor Accessories<span class="caret"></span></a>
													<ul role="menu" class="dropdown-menu">
														<li><a href="equipments.php" style="font-size:16px;">Equipements</a></li>
														<li><a href="medicines.php" style="font-size:16px;">Medicines</a></li>
													</ul>
												</li>
												<li><a href="blog.php" style="font-size:16px;">Blog</a></li>
												<li><a href="about.php" style="font-size:16px;">About</a></li>
												<li><a href="contact.php" style="font-size:16px;">Contact</a></li>
											</ul>
											<ul class="nav navbar-nav navbar-right">
											<li><a href="cart.php" style="font-size:16px;"><span class="glyphicon glyphicon-shopping-cart"></span> Cart <span class="badge"style="font-size:12px;"><?php echo $cnt;?></span></a></li>
												<li><a href="notification.php" style="font-size:17px;"><span class="glyphicon glyphicon-globe" ></span> Notifications <span class="badge"style="font-size:12px;"><?php echo $cnt1;?></span></a></li>
												<li class="dropdown">
													<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" style="font-size:16px;"><?php echo $_SESSION["username"];?><span class="caret"></span></a>
													<ul role="menu" class="dropdown-menu">
														<p style="text-align:center;"><li><a href="profile.php" style="font-size:16px;text-align:center;">Profile</a></li></p>
														<!--<form method="post">
															<li><a href="index.php" style="font-size:16px;" name="logout" id="logout">Logout</a></li>
														</form>-->
														<li>
															<form action="index.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
																<p style="text-align:center;"><input name="logout" type="submit" class="btn btn-success" value="Sign Out"></p>
															</form>
														</li>
													</ul>
												</li>
											</ul>
							<?php
									}
								}
								else if(isset($_SESSION['username']))
								{
									$s="select * from cart where email='".$_SESSION["email"]."'";
									$result = $conn->query($s);
									$cnt=0;
									if ($result->num_rows!=0) 
									{
										while($row = $result->fetch_assoc())
										{ 
											$cnt=$cnt+1;
										}
									}
									$s="select * from notification where rec='".$_SESSION["email"]."' and status=''";
									$result = $conn->query($s);
									$cnt1=0;
									if ($result->num_rows!=0) 
									{
										while($row = $result->fetch_assoc())
										{ 
											$cnt1=$cnt1+1;
										}
									}
							?>
										<ul class="nav navbar-nav">
											<li class="active"><a href="#" style="font-size:16px;">Home</a></li>
											<li><a href="doctor.php" style="font-size:16px;">Find a doctor</a></li>
											<?php 
												if($_SESSION['type']=="doctor")
												{
											?>
													<li><a href="dpanel.php" style="font-size:16px;">Doctor Panel</a></li>
											<?php
												}
											?>
											<li class="dropdown">
											<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" style="font-size:16px;">Doctor Accessories<span class="caret"></span></a>
											<ul role="menu" class="dropdown-menu">
												<li><a href="equipments.php" style="font-size:16px;">Equipements</a></li>
												<li><a href="medicines.php" style="font-size:16px;">Medicines</a></li>
											</ul>
											</li>
											<li><a href="blog.php" style="font-size:16px;">Blog</a></li>
											<li><a href="about.php" style="font-size:16px;">About</a></li>
											<li><a href="contact.php" style="font-size:16px;">Contact</a></li>
										</ul>
										<ul class="nav navbar-nav navbar-right">
										<li><a href="cart.php" style="font-size:16px;"><span class="glyphicon glyphicon-shopping-cart"></span> Cart <span class="badge"style="font-size:12px;"><?php echo $cnt;?></span></a></li>
												<li><a href="notification.php" style="font-size:17px;"><span class="glyphicon glyphicon-globe" ></span> Notifications <span class="badge"style="font-size:12px;"><?php echo $cnt1;?></span></a></li>
												<li class="dropdown">
													<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" style="font-size:16px;"><?php echo $_SESSION["username"];?><span class="caret"></span></a>
													<ul role="menu" class="dropdown-menu">
														<p style="text-align:center;"><li><a href="profile.php" style="font-size:16px;text-align:center;">Profile</a></li></p>
														<!--<form method="post">
															<li><a href="index.php" style="font-size:16px;" name="logout" id="logout">Logout</a></li>
														</form>-->
														<li>
															<form action="index.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
																<p style="text-align:center;"><input name="logout" type="submit" class="btn btn-success" value="Sign Out"></p>
															</form>
														</li>
													</ul>
												</li>
											</ul>
							<?php
								}
								else
								{
									navi();
								}
							?>
						</div>
					</div>
				</nav>	
			</div>
		</div>
		
		<!--\\\\\\\\\\\\\Navigation ber ends here/////////////-->
		
		<!--\\\\\\\\\\\\\sign up form starts here/////////////-->
		
		<div class="modal fade" id="modal-1" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="border-bottom:none">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<br>
                        <h1 class="modal-title">HelpingHand</h1>
                    </div>
                    <div class="modal-body" style="border-top:none">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#section-1" data-toggle="tab" id="tabbeauty">Sign Up</a></li>
							<li><a href="#section-2" data-toggle="tab" id="tabbeauty">Log In</a></li>
						</ul>
                        <div class="tab-content">
							<div class="tab-pane fade in active" id="section-1">
								<br><br>
								<form action="index.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
									<div class="form-group" style="padding-left:59px;">
										<input type="text" name="regemail" id="form-elem-8" class="form-control" placeholder="Email address" style="height:46px;width:449px">
									</div><br><br>
									<div class="form-group" style="padding-left:59px;">
										<input type="text" name="username" id="form-elem-9" class="form-control" placeholder="Username" style="height:46px;width:449px">
									</div><br><br>
									<div class="form-group" style="padding-left:59px;">
										<input type="password" name="password" id="form-elem-10" class="form-control" placeholder="Password" style="height:46px;width:449px">
									</div><br><br>
									<div class="form-group" style="padding-left:59px;">
										<select id="company" class="form-control" style="width:182px;" name="type">
										  <option value="" disabled selected>User Type</option> 
										  <option value="doctor">Doctor</option>
										  <option value="member">Member</option>
										</select> 
									</div><br><br>
									<p style="text-align:center;"><input type="submit" class="btn btn-success btn-lg" value="Create An Account"></p>
								</form>
							</div>
							<div class="tab-pane fade" id="section-2">
								<br><br>
								<form action="index.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
									<div class="form-group" style="padding-left:59px;">
										<input type="text" id="form-elem-6" name="email" class="form-control" placeholder="Email address" style="height:46px;width:449px">
									</div><br><br>
									<div class="form-group" style="padding-left:59px;">
										<input type="password" id="form-elem-7" name="password" class="form-control" placeholder="Password"style="height:46px;width:449px">
									</div><br><br>
									<span style="padding-left:59px;">
										<input type="checkbox">Remember me 
										<a href="" style="text-decoration:none;padding-left:200px;">Forgot your password?</a>
									</span><br><br>
									<p style="text-align:center;"><input type="submit" class="btn btn-success btn-lg" value="Log In" data-toggle="modal" data-target="#modal-3"></p>
								</form>
							</div>
						</div>
					</div>
                    <div class="modal-footer" style="padding-right:70px;padding-bottom:50px;">
						<p style="padding-right:180px;color:gray;">Or connect with</p>
						<div class="row">
							<div class="col-lg-4">
								<a data-attr2="Login" data-attr1="master" data-analytics="SignupFacebook" class="btn btn-facebook btn-social" style="padding-top:10px;height:41px;width:97px;">Facebook</a>
							</div><!-- /.col-lg-4 -->
							<div class="col-lg-4">
								<a data-attr2="Login" data-attr1="master" data-analytics="SignupGoogle" class="btn btn-google btn-social" style="padding-top:10px;height:41px;width:97px;">Google</a>
							</div><!-- /.col-lg-4 -->
							<div class="col-lg-4">
								<a data-attr2="Login" data-attr1="master" data-analytics="SignupGithub" class="btn btn-github btn-social" style="padding-top:10px;height:41px;width:97px;"> GitHub</a>
							</div><!-- /.col-lg-4 -->
						</div><!-- /.row -->
					</div><!-- /.container -->
				</div>
			</div>
		</div>
		
		<!--\\\\\\\\\\\\\sign up form ends here/////////////-->
		
		<!--\\\\\\\\\\\\\Log In form starts here/////////////-->
		
		<div class="modal fade" id="modal-2" tabindex="-1" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="border-bottom:none">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<br>
                        <h1 class="modal-title">HelpingHand</h1>
                    </div>
                    <div class="modal-body" style="border-top:none">
						<ul class="nav nav-tabs">
							<li class="active"><a href="#section-3" data-toggle="tab" id="tabbeauty">Log In</a></li>
							<li><a href="#section-4" data-toggle="tab" id="tabbeauty">Sign Up</a></li>
						</ul>
                        <div class="tab-content">
							<div class="tab-pane fade in active" id="section-3">
								<br><br>
								<form action="index.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
									<div class="form-group" style="padding-left:59px;">
										<input type="text" id="form-elem-6" name="email" class="form-control" placeholder="Email address" style="height:46px;width:449px">
									</div><br><br>
									<div class="form-group" style="padding-left:59px;">
										<input type="password" id="form-elem-7" name="password" class="form-control" placeholder="Password"style="height:46px;width:449px">
									</div><br><br>
									<span style="padding-left:59px;">
										<input type="checkbox">Remember me 
										<a href="" style="text-decoration:none;padding-left:200px;">Forgot your password?</a>
									</span><br><br>
									<p style="text-align:center;"><input type="submit" class="btn btn-success btn-lg" value="Log In" data-toggle="modal" data-target="#modal-3"></p>
								</form>
							</div>
							<div class="tab-pane fade" id="section-4">
								<br><br>
								<form action="index.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
									<div class="form-group" style="padding-left:59px;">
										<input type="text" name="regemail" id="form-elem-8" class="form-control" placeholder="Email address" style="height:46px;width:449px">
									</div><br><br>
									<div class="form-group" style="padding-left:59px;">
										<input type="text" name="username" id="form-elem-9" class="form-control" placeholder="Username" style="height:46px;width:449px">
									</div><br><br>
									<div class="form-group" style="padding-left:59px;">
										<input type="password" name="password" id="form-elem-10" class="form-control" placeholder="Password" style="height:46px;width:449px">
									</div><br><br>
									<div class="form-group" style="padding-left:59px;">
										<select id="company" class="form-control" style="width:182px;" name="type">
										  <option value="" disabled selected>User Type</option> 
										  <option value="doctor">Doctor</option>
										  <option value="member">Member</option>
										</select> 
									</div><br><br>
									<p style="text-align:center;"><input type="submit" class="btn btn-success btn-lg" value="Create An Account"></p>
								</form>
							</div>
						</div>
					</div>
                    <div class="modal-footer" style="padding-right:70px;padding-bottom:50px;">
						<p style="padding-right:180px;color:gray;">Or connect with</p>
						<div class="row">
							<div class="col-lg-4">
								<a data-attr2="Login" data-attr1="master" data-analytics="SignupFacebook" class="btn btn-facebook btn-social" style="padding-top:10px;height:41px;width:97px;">Facebook</a>
							</div><!-- /.col-lg-4 -->
							<div class="col-lg-4">
								<a data-attr2="Login" data-attr1="master" data-analytics="SignupGoogle" class="btn btn-google btn-social" style="padding-top:10px;height:41px;width:97px;">Google</a>
							</div><!-- /.col-lg-4 -->
							<div class="col-lg-4">
								<a data-attr2="Login" data-attr1="master" data-analytics="SignupGithub" class="btn btn-github btn-social" style="padding-top:10px;height:41px;width:97px;"> GitHub</a>
							</div><!-- /.col-lg-4 -->
						</div><!-- /.row -->
					</div><!-- /.container -->
				</div>
			</div>
		</div>
		<!--\\\\\\\\\\\\\Log In form ends here/////////////-->
		
		<!--profile starts here-->
		<?php
			$emm=$_SESSION["email"];
			$pw=$_SESSION["password"];
			$user=$_SESSION["username"];
			$fir="";
			$las="";
			$name="";
			$pas="";
			$cpas="";
			$gen="";
			$cred="";
			$add="";
			$ph="";
			$img_url="";
			$s="select user_id from users where email='".$_SESSION["email"]."'";
			$result = $conn->query($s);
			if ($result->num_rows!=0) 
			{
				if($row = $result->fetch_assoc())
				{ 
					$_SESSION["u_id"]=$row["user_id"];
				}
			}
			$t=0;
			$s="select * from profile where u_id='".$_SESSION["u_id"]."'";
			$result = $conn->query($s);
			if ($result->num_rows!=0) 
			{
				$t=0;
			}
			else
			{
				$t=1;
			}
			if(isset($_POST['upp']))
			{
				$fir=$_POST['firstName'];
				$las=$_POST['lastName'];
				$name=$fir." ".$las;
				$pas=$_POST['passw'];
				$cpas=$_POST['confirmPassword'];
				$gen=$_POST['gender'];
				$cred=$_POST['cred'];
				$add=$_POST['senderAddress'];
				$ph=$_POST['senderPhone'];
				$img_file=$_FILES['img']['tmp_name'];
				$target_file=basename($_FILES['img']['name']);
				$upload_dir="img/";
				$_SESSION["password"]=$pas;
				$pw=$pas;
				move_uploaded_file($img_file, $upload_dir."/".$target_file);
				// Perform Update
				$img_url =$target_file ;
				if($t==1)
				{
					if(isset($_SESSION['type']))
					{
						if($_SESSION['type']=='doctor')
						{
							$s="INSERT INTO profile (u_id,fstname,lstname,gender,credit_card,pic) VALUES('".$_SESSION["u_id"]."','$fir','$las','$gen','$cred','$img_url')";
							$conn->query($s);
							$sql = "UPDATE users SET password=\"$pas\" WHERE user_id='".$_SESSION["u_id"]."'";
							$conn->query($sql);
							$s="INSERT INTO doctors (u_id,name,location,phn,email) VALUES('".$_SESSION["u_id"]."','$name','$add','$ph','".$_SESSION["email"]."')";
							$conn->query($s);
						}
						else
						{
							$s="INSERT INTO profile (u_id,fstname,lstname,gender,credit_card,phn,address,pic) VALUES('".$_SESSION["u_id"]."','$fir','$las','$gen','$cred','$ph','$add','$img_url')";
							$conn->query($s);
							$sql = "UPDATE users SET password=\"$pas\" WHERE user_id='".$_SESSION["u_id"]."'";
							$conn->query($sql);
						}
					}
				}
				else
				{
					if(isset($_SESSION['type']))
					{
						if($_SESSION['type']=='doctor')
						{
							if($img_url=="")
							{
								$s="UPDATE profile SET fstname=\"$fir\",lstname=\"$las\",gender=\"$gen\",credit_card=\"$cred\" where u_id='".$_SESSION["u_id"]."'";
							}
							else
							{
								$s="UPDATE profile SET fstname=\"$fir\",lstname=\"$las\",gender=\"$gen\",credit_card=\"$cred\",pic=\"$img_url\" where u_id='".$_SESSION["u_id"]."'";
							}
							$conn->query($s);
							$sql = "UPDATE users SET password=\"$pas\" WHERE user_id='".$_SESSION["u_id"]."'";
							$conn->query($sql);
							$em=$_SESSION["email"];
							$s="UPDATE doctors SET name=\"$name\",location=\"$add\",phn=\"$ph\",email=\"$em\" where u_id='".$_SESSION["u_id"]."'";
							$conn->query($s);
						}
						else
						{
							if($img_url=="")
							{
								$s="UPDATE profile SET fstname=\"$fir\",lstname=\"$las\",gender=\"$gen\",credit_card=\"$cred\",phn=\"$ph\",address=\"$add\" where u_id='".$_SESSION["u_id"]."'";
							}
							else
							{
								$s="UPDATE profile SET fstname=\"$fir\",lstname=\"$las\",gender=\"$gen\",credit_card=\"$cred\",phn=\"$ph\",address=\"$add\",pic=\"$img_url\" where u_id='".$_SESSION["u_id"]."'";
							}
							$conn->query($s);
							$sql = "UPDATE users SET password=\"$pas\" WHERE user_id='".$_SESSION["u_id"]."'";
							$conn->query($sql);
						}
					}
				}
			}
			
			$s="select * from profile where u_id='".$_SESSION["u_id"]."'";
			$result = $conn->query($s);
			if ($result->num_rows!=0) 
			{
				if($row = $result->fetch_assoc())
				{
					$fir=$row["fstname"];
					$las=$row["lstname"];
					$gen=$row["gender"];
					$cred=$row["credit_card"];
					if($_SESSION['type']=='doctor')
					{
						$s="select * from doctors where u_id='".$_SESSION["u_id"]."'";
						$result = $conn->query($s);
						if ($result->num_rows!=0) 
						{
							if($row = $result->fetch_assoc())
							{
								$add=$row["location"];
								$ph=$row["phn"];
							}
						}
					}
					else
					{
						$add=$row["address"];
						$ph=$row["phn"];
					}
				}
			}
		?>
		<div class="container" >
			<div class="row" >
				<div class="col-sm-8 col-sm-offset-2">
					<div class="page-header">
						<h2>Profile</h2>
					</div>
					
					<form id="defaultForm" method="post" class="form-horizontal" action="profile.php" enctype="multipart/form-data">
						<div class="form-group">
							<label class="col-sm-3 control-label">Full name</label>
							<div class="col-sm-4">
							<textarea class="form-control" rows="1" name="firstName"
											required data-fv-notempty-message="First name" placeholder="First name" maxlength="75"><?php echo $fir;?></textarea>
							</div>
							<div class="col-sm-4">
								<input type="text" class="form-control" name="lastName" placeholder="Last name" value=<?php echo $las;?> >
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Username</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" value=<?php echo $user;?> readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Email address</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" value=<?php echo $emm;?> readonly>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Password</label>
							<div class="col-sm-4">
								<input type="password" class="form-control" name="passw" required value=<?php echo $pw;?> >
							</div>
							<div class="col-sm-4">
								 <input type="password" class="form-control" name="confirmPassword" placeholder="Confirm" required value=<?php echo $pw;?>>
		
							</div>
						</div>
							
				   <div class="form-group">
							<label class="col-sm-3 control-label">Gender</label>
							<div class="col-sm-6">
								<div class="radio">
									<label>
										<input type="radio" name="gender" value="Male" <?php if($gen=="Male")echo "checked"?> /> Male
									</label>
								</div>
								<div class="radio">
									<label>
										<input type="radio" name="gender" value="Female" <?php if($gen=="Female")echo "checked"?> /> Female
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Credit Card No.</label>
							<div class="col-sm-5">
								<input type="text" class="form-control" name="cred" required value=<?php echo $cred;?>>
							</div>
						</div>
						<div class="form-group">
								<label class="col-lg-3 control-label">Address</label>
								<div class="col-lg-5">
									 <textarea class="form-control" rows="5" name="senderAddress"
											required data-fv-notempty-message="The address is required" maxlength="75"><?php echo $add;?></textarea>
								</div>
							</div>
							<div class="form-group">
							<label class="col-lg-3 control-label">Phone</label>
							<div class="col-lg-5">
								<input class="form-control" type="text" name="senderPhone" value=<?php echo $ph;?> >
							</div>
							</div>
							<div class="form-group">
							<br>
							<div class="col-lg-5 col-sm-offset-3">
								<br>
								<input type="file" accept="image/*" onchange="loadFile(event)" name="img" id="img">
								<img id="output" style="width:70%; margin-top:10px;"/>
							</div>
							</div>
							<br>
							<div class="form-group">
							<div class="col-sm-8 col-sm-offset-4">
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<button type="submit" class="btn btn-primary" name="upp" value="upp">Update</button>
							</div>
						</div>
						<?php
						if(isset($_SESSION['type']))
						{
							if($_SESSION['type']=='doctor')
							{
						?>
							<br>
							<p style="color:red;font-size:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Go to <a href="dpanel.php" style="text-decoration:none;">Doctor Panel</a> to edit your information and visit hours.</p>
						<?php
							}
						}
						?>
						<br>
					</form>
				</div>
			</div>
		</div>
		<!--profile ends here-->
		<!-- FOOTER Starts Here-->
		
		<link href="css/font-awesome.min.css" rel="stylesheet">
		<footer>
			<div class="footer" id="footer" style="background-color:#353535;">
				<div class="container">
					<div class="row">
						<div class="col-sm-4 col-xs-offset-1">
							</br>
							</br>
							</br>
							</br>
							<h1 style="color:white;">HelpingHand</h1>
							<p id="footercopy"> Copyright &copy 2015. All right reserved. </p>
							</br>
							<p style="padding-left:10px;">
								<a target="_blank" href="https://www.facebook.com">Facebook</a>
								-
								<a target="_blank" href="https://twitter.com">Twitter</a>
								-
								<a target="_blank" href="https://www.linkedin.com">LinkedIn</a>
							</p>
						</div>
						<div class="col-sm-2">
							<h3 id="footertext"> Company </h3>
							<ul>
								<li> <a href="#" id="footerli"> About Us </a> </li>
								<li> <a href="#" id="footerli"> Interns </a> </li>
								<li> <a href="#" id="footerli"> Careers </a> </li>
								<li> <a href="#" id="footerli"> Blog </a> </li>
							</ul>
						</div>
						<div class="col-sm-2">
							<h3 id="footertext"> Docs </h3>
							<ul>
								<li> <a href="#" id="footerli"> Scoring </a> </li>
								<li> <a href="#" id="footerli"> Environment </a> </li>
								<li> <a href="#" id="footerli"> FAQ </a> </li>
							</ul>
						</div>
						<div class="col-sm-2">
							<h3 id="footertext"> Others </h3>
							<ul>
								<li> <a href="#" id="footerli"> Privacy Policy </a> </li>
								<li> <a href="#" id="footerli"> Free Node </a> </li>
								<li> <a href="#" id="footerli"> About Us </a> </li>
							</ul>
						</div>
					</div>
					</br>
					</br>
            <!--/.row--> 
				</div>
        <!--/.container--> 
			</div>
		</footer>
		<?php
			mysqli_close($conn);
			ob_end_flush();
		?>
		<!--/.footer Ends Here-->
		
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