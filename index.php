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
		
		<!-- Carousel
		================================================== -->
		<div data-ride="carousel" class="carousel slide" id="myCarousel" style="height:600px;">
		<!-- Indicators -->
			<ol class="carousel-indicators">
				<li class="" data-slide-to="0" data-target="#myCarousel"></li>
				<li data-slide-to="1" data-target="#myCarousel" class=""></li>
				<li data-slide-to="2" data-target="#myCarousel" class="active"></li>
			</ol>
			<div role="listbox" class="carousel-inner" style="height:600px;">
				<div class="item active">
					<img alt="First slide" src="img/bigstock-Medical-doctors-group-Isolate-27388721.jpg">
					<div class="container">
						<div class="carousel-caption">
							<h1>vasdasd</h1>
							<p>fasdasd</p>
							<p><a role="button" href="#" class="btn btn-lg btn-primary">Sign up today</a></p>
						</div>
					</div>
				</div>
				<div class="item">
					<img alt="Second slide" src="img/Stethoscope.jpg">
					<div class="container">
						<div class="carousel-caption">
							<h1>asfasda</h1>
							<p>falasfasf</p>
							<p><a role="button" href="#" class="btn btn-lg btn-primary">Learn more</a></p>
						</div>
					</div>
				</div>
				<div class="item">
					<img alt="Third slide" src="img/medicine.jpg">
					<div class="container">
						<div class="carousel-caption">
							<h1>asfasf</h1>
							<p>faltasfasfasfa</p>
							<p><a role="button" href="#" class="btn btn-lg btn-primary">Browse gallery</a></p>
						</div>
					</div>
				</div>
			</div>
			<a data-slide="prev" role="button" href="#myCarousel" class="left carousel-control">
				<span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span>
				<span class="sr-only">Previous</span>
			</a>
			<a data-slide="next" role="button" href="#myCarousel" class="right carousel-control">
				<span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span>
				<span class="sr-only">Next</span>
			</a>
		</div>
		
		<!-- /.carousel ends here -->
	
		<!-- Marketing messaging and featurettes
		================================================== -->
		<!-- Wrap the rest of the page in another container to center all the content. -->

		<div class="container marketing">	

			<!-- Three columns of text below the carousel -->
			<div class="row">
				<div class="col-lg-12">
					<ul class="hr-mission-highlights unstyled row">
						<li class=" hr-mission-highlight span-xs-16 span-md-8" style="list-style:none;">
							<div class="hr-mission-figure hr-mission-developers is-active">
								<span class="hr-mission-content">
									<img src="img/people.png" alt="People">
									<p style="font-size:18px;padding-top:10px;">Experienced<br>
									Doctors</p>
								</span>
							</div>
						</li>
						<li class=" hr-mission-highlight span-xs-16 span-md-8" style="padding-left:118px;list-style:none;">
							<div class="hr-mission-figure hr-mission-challenges is-active">
								<span class="hr-mission-content">
									<img src="img/medal_of_honor.png" alt="Medal_of_honor">
									<p style="font-size:18px;padding-top:10px;">1000+<br>
									Equiqments</p>
								</span>
							</div>
						</li>
						<li class=" hr-mission-highlight span-xs-16 span-md-8" style="padding-left:225px;list-style:none;">
							<div class="hr-mission-figure hr-mission-companies is-active">
								<span class="hr-mission-content">
									<img src="img/suitcase.png" alt="Suitcase" style="padding-right:3px;">
									<p style="font-size:18px;padding-top:10px;">1000+<br>
									Medicines</p>
								</span>
							</div>
						</li>
					</ul>
				</div><!-- /.col-lg-12 -->
			</div><!-- /.row -->
		</div><!-- /.container -->
		<br><br><br><br>
		<div class="container marketing">

			<!-- Three columns of text below the carousel -->
			<div class="row">
				<div class="col-lg-4">
				  <h2>Heading</h2>
				  <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
				  <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
				</div><!-- /.col-lg-4 -->
				<div class="col-lg-4">
				  <h2>Heading</h2>
				  <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
				  <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
				</div><!-- /.col-lg-4 -->
				<div class="col-lg-4">
				  <h2>Heading</h2>
				  <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
				  <p><a role="button" href="#" class="btn btn-default">View details »</a></p>
				</div><!-- /.col-lg-4 -->
			</div><!-- /.row -->
		</div>
		
		<!-- /.Marketing container end here-->
		
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