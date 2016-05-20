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
		
		<script src="js/jquery-2.1.3.min.js"></script>
		<!-- Just for debugging purposes -->
		<script src="bootstrap-3.3.2-dist/js/ie-emulation-modes-warning.js"></script>
		
		
		<script src="bootstrap-3.3.2-dist/js/jquery.min.js"></script>
		<link rel="stylesheet" href="css/jquery-ui.min.css">
		<script type="text/javascript" src="js/jquery-ui.min.js"></script>
		<script>
		$(document).ready(function() {
			src = "autocomp.php";

			// Load the cities straight from the server, passing the country as an extra param
			$("#query").autocomplete({
				source: function(request, response) {
					$.ajax({
						url: src,
						dataType: "json",
						data: {
							term : request.term,
							typee : $('.search-panel span#search_concept').text()
						},
						success: function(data) {
							response(data);
						}
					});
				},
				min_length: 3,
				delay: 300
			});
			});
		$(document).ready(function(e){
			$('.search-panel .dropdown-menu').find('a').click(function(e) {
				e.preventDefault();
				var param = $(this).attr("href").replace("#","");
				var concept = $(this).text();
				$('.search-panel span#search_concept').text(concept);
				$('.input-group #search_param').val(param);
			});
		});	
		</script>
		<style>
			body{
				padding-top:50px;
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
		<!--\\\\\\\\\\\\\Navigation ber starts here/////////////-->
		<?php
			function navi()
			{
		?>
				<ul class="nav navbar-nav">
					<li><a href="index.php" style="font-size:16px;">Home</a></li>
					<li><a href="doctor.php" style="font-size:16px;">Find a doctor</a></li>
					<li class="dropdown">
					<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" style="font-size:16px;">Doctor Accessories<span class="caret"></span></a>
					<ul role="menu" class="dropdown-menu">
						<li><a href="equipments.php" style="font-size:16px;">Equipements</a></li>
						<li class="active"><a href="#" style="font-size:16px;">Medicines</a></li>
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
											if(isset($_POST['cart'])&&isset($_SESSION['username']))
											{
												$s="select * from cart where med_id='".$_POST['cart']."' and email='".$_SESSION["email"]."'";
												$result = $conn->query($s);
												if ($result->num_rows==0) 
												{
													$s="select * from medicines where med_id='".$_POST['cart']."'";
													$result = $conn->query($s);
													if ($result->num_rows!=0) 
													{	
														if($row = $result->fetch_assoc())
														{ 
															$date=date("d/m/Y");
															$quan=1;
															$quant=$row["quan"];
															$sql = "INSERT INTO cart(email,med_id,quan,date,ctgry) VALUES ('".$_SESSION["email"]."', '".$_POST['cart']."','$quan','".$date."','med')";
															mysqli_query($conn, $sql);
															$quant=$quant-$quan;
															$sql = "UPDATE medicines SET quan=\"$quant\" WHERE med_id='".$_POST['cart']."'";
															$conn->query($sql);
														}
													}
												}
												else 
												{
													if($row = $result->fetch_assoc())
													{
															$c_id=$row["c_id"];
															$quant1=$row["quan"];
													}
													$s="select * from medicines where med_id='".$_POST['cart']."'";
													$result = $conn->query($s);
													if ($result->num_rows!=0) 
													{
														if($row = $result->fetch_assoc())
														{ 
															$quant=$row["quan"];
															$date=date("d/m/Y");
															$quan=1;
															$quant=$quant-$quan;
															$sql = "UPDATE medicines SET quan=\"$quant\" WHERE med_id='".$_POST['cart']."'";
															$conn->query($sql);
															$quant1=$quant1+$quan;
															$sql = "UPDATE cart SET quan=\"$quant1\" WHERE c_id='".$c_id."'";
															$conn->query($sql);
														}
													}
												}
											}
											else if(isset($_POST['cart']))
											{
												echo "bla";
											}
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
												<li><a href="index.php" style="font-size:16px;">Home</a></li>
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
														<li class="active"><a href="#" style="font-size:16px;">Medicines</a></li>
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
															<form action="medicines.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
										if(isset($_POST['cart'])&&isset($_SESSION['username']))
										{
											$s="select * from cart where med_id='".$_POST['cart']."' and email='".$_SESSION["email"]."'";
											$result = $conn->query($s);
											if ($result->num_rows==0) 
											{
												$s="select * from medicines where med_id='".$_POST['cart']."'";
												$result = $conn->query($s);
												if ($result->num_rows!=0) 
												{	
													if($row = $result->fetch_assoc())
													{ 
														$date=date("d/m/Y");
														$quan=1;
														$quant=$row["quan"];
														$sql = "INSERT INTO cart(email,med_id,quan,date,ctgry) VALUES ('".$_SESSION["email"]."', '".$_POST['cart']."','$quan','".$date."','med')";
														mysqli_query($conn, $sql);
														$quant=$quant-$quan;
														$sql = "UPDATE medicines SET quan=\"$quant\" WHERE med_id='".$_POST['cart']."'";
														$conn->query($sql);
													}
												}
											}
											else 
											{
												if($row = $result->fetch_assoc())
												{
														$c_id=$row["c_id"];
														$quant1=$row["quan"];
												}
												$s="select * from medicines where med_id='".$_POST['cart']."'";
												$result = $conn->query($s);
												if ($result->num_rows!=0) 
												{
													if($row = $result->fetch_assoc())
													{ 
														$quant=$row["quan"];
														$date=date("d/m/Y");
														$quan=1;
														$quant=$quant-$quan;
														$sql = "UPDATE medicines SET quan=\"$quant\" WHERE med_id='".$_POST['cart']."'";
														$conn->query($sql);
														$quant1=$quant1+$quan;
														$sql = "UPDATE cart SET quan=\"$quant1\" WHERE c_id='".$c_id."'";
														$conn->query($sql);
													}
												}
											}
										}
										else if(isset($_POST['cart']))
										{
											echo "bla";
										}
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
												<li><a href="index.php" style="font-size:16px;">Home</a></li>
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
														<li class="active"><a href="#" style="font-size:16px;">Medicines</a></li>
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
															<form action="medicines.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
									if(isset($_POST['cart'])&&isset($_SESSION['username']))
									{
										$s="select * from cart where med_id='".$_POST['cart']."' and email='".$_SESSION["email"]."'";
										$result = $conn->query($s);
										if ($result->num_rows==0) 
										{
											$s="select * from medicines where med_id='".$_POST['cart']."'";
											$result = $conn->query($s);
											if ($result->num_rows!=0) 
											{	
												if($row = $result->fetch_assoc())
												{ 
													$date=date("d/m/Y");
													$quan=1;
													$quant=$row["quan"];
													$sql = "INSERT INTO cart(email,med_id,quan,date,ctgry) VALUES ('".$_SESSION["email"]."', '".$_POST['cart']."','$quan','".$date."','med')";
													mysqli_query($conn, $sql);
													$quant=$quant-$quan;
													$sql = "UPDATE medicines SET quan=\"$quant\" WHERE med_id='".$_POST['cart']."'";
													$conn->query($sql);
												}
											}
										}
										else 
										{
											if($row = $result->fetch_assoc())
											{
													$c_id=$row["c_id"];
													$quant1=$row["quan"];
											}
											$s="select * from medicines where med_id='".$_POST['cart']."'";
											$result = $conn->query($s);
											if ($result->num_rows!=0) 
											{
												if($row = $result->fetch_assoc())
												{ 
													$quant=$row["quan"];
													$date=date("d/m/Y");
													$quan=1;
													$quant=$quant-$quan;
													$sql = "UPDATE medicines SET quan=\"$quant\" WHERE med_id='".$_POST['cart']."'";
													$conn->query($sql);
													$quant1=$quant1+$quan;
													$sql = "UPDATE cart SET quan=\"$quant1\" WHERE c_id='".$c_id."'";
													$conn->query($sql);
												}
											}
										}
									}
									else if(isset($_POST['cart']))
									{
										echo "bla";
									}
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
											<li><a href="index.php" style="font-size:16px;">Home</a></li>
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
												<li class="active"><a href="#" style="font-size:16px;">Medicines</a></li>
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
															<form action="medicines.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
		
		<!--\\\\\\\\\\\\\search bar starts here//////////////-->
		<form role="search" action="medicines.php" role="form"  method="post" enctype="multipart/form-data">
		<div class="container" style="margin-top:40px;">
			<div class="row">    
				<div class="col-xs-8 col-xs-offset-2">
					<div class="input-group">
						<div class="input-group-btn search-panel">
							<button type="button" class="btn btn-beau dropdown-toggle" data-toggle="dropdown">
								<span id="search_concept">Filter by</span> <span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
							  <li><a href="#medicine">Medicine</a></li>
							  <li><a href="#disease">Disease</a></li>
							</ul>
						</div>
						<input type="hidden" name="search_param" value="all" id="search_param">         
						<input type="text" class="form-control" name="search" placeholder="Search term..." id="query">
						<span class="input-group-btn">
							<button class="btn btn-beau" type="submit"><span class="glyphicon glyphicon-search" style="height:20px;width:65px;font-size:20px;"></span></button>
						</span>
					</div>
				</div>
			</div>
		</div>
		</form>
		
		<!--\\\\\\\\\\\\\search bar ends here//////////////-->
		
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
								<form action="medicines.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
								<form action="medicines.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
								<form action="medicines.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
								<form action="medicines.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
		
		
	
		<!-- Marketing messaging and featurettes
		================================================== -->
		<!-- Wrap the rest of the page in another container to center all the content. -->
        
		
			<br><br><br>
			<section class="catalog-grid">
				<div class="container">
				  <div class="row">
			<?php
			$i=0;
			$m_id=array();
			$m_id1=array();
			$m_name=array();
			$ctg=array();
			$price=array();
			$pic=array();
			if(isset($_POST['search']))
			{
				$t=0;
				$s="select * from medicines where name LIKE'".$_POST['search']."%'";
				if(isset($_POST['search_param']))
				{
					if($_POST['search_param']=="disease")
					{
						$s="select * from medicines where ctgry LIKE'".$_POST['search']."%'";
					}
					else if($_POST['search_param']=="medicine")
					{
						$s="select * from medicines where name LIKE'".$_POST['search']."%'";
					}
					else
					{
						$result = $conn->query($s);
						if ($result->num_rows!=0) 
						{
							$t=1;
							while($row = $result->fetch_assoc())
							{ 
								$m_id[$i]='item.php?p_id='.$row["med_id"];
								$m_id1[$i]=$row["med_id"];
								$m_name[$i]=$row["name"];
								$ctg[$i]=$row["ctgry"];
								$price[$i]=$row["price"];
								$pic[$i]='img/'.$row["pic"];
								$_SESSION["tp"]="med";
								$i=$i+1;
							}
						}
						else
						{
							$s="select * from medicines where ctgry LIKE'".$_POST['search']."%'";
						}
					}
				}
				$result = $conn->query($s);
				if ($result->num_rows!=0&&$t==0) 
				{
					while($row = $result->fetch_assoc())
					{ 
						$m_id[$i]='item.php?p_id='.$row["med_id"];
						$m_id1[$i]=$row["med_id"];
						$m_name[$i]=$row["name"];
						$ctg[$i]=$row["ctgry"];
						$price[$i]=$row["price"];
						$pic[$i]='img/'.$row["pic"];
						$_SESSION["tp"]="med";
						$i=$i+1;
					}
				}
				else if($t==0)
				{
				?>
				<h2 style="color:red;margin-left:210px;">Result not found!!!</h2>
				<br><br><br><br><br>
				<?php
				}
			}
			else
			{
				$s="select * from medicines";
				$result = $conn->query($s);
				if ($result->num_rows!=0) 
				{
					while($row = $result->fetch_assoc())
					{ 
						$m_id[$i]='item.php?p_id='.$row["med_id"];
						$m_id1[$i]=$row["med_id"];
						$m_name[$i]=$row["name"];
						$ctg[$i]=$row["ctgry"];
						$price[$i]=$row["price"];
						$pic[$i]='img/'.$row["pic"];
						$_SESSION["tp"]="med";
						$i=$i+1;
					}
				}
			}
			for($j=0;$j<$i;$j++)
			{
		?>

			
          	<!--Tile-->
          	<div class="col-lg-3 col-md-4 col-sm-6">
            	<div class="tile">
              	<div class="price-label">BDT <?php echo $price[$j];?> Taka</div>
              	 <a href=<?php echo $m_id[$j];?>>
                  <img alt="1" src=<?php echo $pic[$j];?> height="288px" width="261px">
                  <span class="tile-overlay"></span>
                </a>
                <div class="itemfooter">
                	<a href=<?php echo $m_id[$j];?>><?php echo $m_name[$j];?></a>
                  <span><?php echo $ctg[$j];?></span>
				  <form action="medicines.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
					<button class="btn btn-beau" name="cart" value=<?php echo $m_id1[$j];?>><span class="glyphicon glyphicon-shopping-cart"></span>Add to Cart</button>
				  </form>
                </div>
              </div>
            </div>
			<?php
			}
			if(!isset($_POST['search']))
			{
			?>
          	<!--Tile-->
          	<div class="col-lg-3 col-md-4 col-sm-6">
            	<div class="tile">
              	<div class="price-label">715,00 $</div>
              	 <a href="shop-single-item-v1.html">
                  <img alt="1" src="img/catalog/5.jpg">
                  <span class="tile-overlay"></span>
                </a>
                <div class="itemfooter">
                	<a href="#">Shopper with buckle</a>
                  <span>by Ivan Tookle</span>
                  <button class="btn btn-beau">Add to Cart</button>
                </div>
              </div>
            </div>
            <!--Tile-->
          	<div class="col-lg-3 col-md-4 col-sm-6">
            	<div class="tile">
              	<div class="price-label">715,00 $</div>
              	 <a href="shop-single-item-v1.html">
                  <img alt="1" src="img/catalog/6.jpg">
                  <span class="tile-overlay"></span>
                </a>
                <div class="itemfooter">
                	<a href="#">City bag</a>
                  <span>by Carol Flag</span>
                  <button class="btn btn-beau">Add to Cart</button>
                </div>
              </div>
            </div>
            <!--Tile-->
          	<div class="col-lg-3 col-md-4 col-sm-6">
            	<div class="tile">
              	<div class="price-label">715,00 $</div>
              	 <a href="shop-single-item-v1.html">
                  <img alt="1" src="img/catalog/7.jpg">
                  <span class="tile-overlay"></span>
                </a>
                <div class="itemfooter">
                	<a href="#">Cheap Zip Bag</a>
                  <span>by Aron Tag</span>
                  <button class="btn btn-beau">Add to Cart</button>
                </div>
              </div>
            </div>
            <!--Tile-->
          	<div class="col-lg-3 col-md-4 col-sm-6">
            	<div class="tile">
              	<div class="price-label">715,00 $</div>
              	 <a href="shop-single-item-v1.html">
                  <img alt="1" src="img/catalog/8.jpg">
                  <span class="tile-overlay"></span>
                </a>
                <div class="itemfooter">
                	<a href="#">Leather bag with side pocket</a>
                  <span>by Anna Canara</span>
                  <button class="btn btn-beau">Add to Cart</button>
                </div>
              </div>
            </div>
			<?php
			}
			?>
          </div>
        </div>
      </section>
			
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
							<p>
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
			<!--/.footer-->
		</footer>
		<?php
			mysqli_close($conn);
			ob_end_flush();
		?>
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		
		<script src="bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
		<script src="bootstrap-3.3.2-dist/js/docs.min.js"></script>
		<script src="js/myjs.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="bootstrap-3.3.2-dist/js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>