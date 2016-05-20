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
		<style>
			body{
				padding-top:50px;
			}
		</style>
		<script type="text/javascript">         
            function increase(t,s,c){
				var textBox = document.getElementById(s);
				textBox.value++;
				document.getElementById(c).innerHTML = "BDT "+textBox.value*t+" Taka";
				var total1=document.getElementById("total1");
				s=parseInt(total1.value)+t;
				total1.value=s;
				document.getElementById("total2").innerHTML =  (s+500)+" Taka";
				
            }
			function decrease(t,s,c){
				var textBox = document.getElementById(s);
				if(textBox.value!=1)
					textBox.value--;
				document.getElementById(c).innerHTML = "BDT "+textBox.value*t+" Taka";
				var total1=document.getElementById("total1");
				s=parseInt(total1.value)-t;
				total1.value=s;
				document.getElementById("total2").innerHTML =  (s+500)+" Taka";
            }	
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
			if(isset($_POST['st']))
			{
				$cc_id=array();
				$med_id=array();
				$quantt=array();
				$s="select c_id,med_id,quan from cart";
				$result = $conn->query($s);
				if ($result->num_rows!=0) 
				{
					$i=0;
					while($row = $result->fetch_assoc())
					{ 
						$cc_id[$i]=$row["c_id"];
						$med_id[$i]=$row["med_id"];
						$quantt[$i]=$row["quan"];
						$i=$i+1;
					}
				}
				for($j=0;$j<$i;$j++)
				{
					//echo $_GET[$cc_id[$j]];
					if($_POST[$cc_id[$j]]>$quantt[$j])
					{
						$cr_quan=$_POST[$cc_id[$j]]-$quantt[$j];
						$caradd=$quantt[$j]+$cr_quan;
						$sql = "UPDATE cart SET quan=\"$caradd\" WHERE c_id='".$cc_id[$j]."'";
						$conn->query($sql);
						$s="select * from medicines where med_id='".$med_id[$j]."'";
						$result = $conn->query($s);
						if ($result->num_rows!=0) 
						{	
							if($row = $result->fetch_assoc())
							{ 
								$quant=$row["quan"];
								$quant=$quant-$cr_quan;
								$sql = "UPDATE medicines SET quan=\"$quant\" WHERE med_id='".$med_id[$j]."'";
								$conn->query($sql);
							}
						}
					}
					else if($_POST[$cc_id[$j]]<$quantt[$j])
					{
						$cr_quan=$quantt[$j]-$_POST[$cc_id[$j]];
						$caradd=$quantt[$j]-$cr_quan;
						$sql = "UPDATE cart SET quan=\"$caradd\" WHERE c_id='".$cc_id[$j]."'";
						$conn->query($sql);
						$s="select * from medicines where med_id='".$med_id[$j]."'";
						$result = $conn->query($s);
						if ($result->num_rows!=0) 
						{	
							if($row = $result->fetch_assoc())
							{ 
								$quant=$row["quan"];
								$quant=$quant+$cr_quan;
								$sql = "UPDATE medicines SET quan=\"$quant\" WHERE med_id='".$med_id[$j]."'";
								$conn->query($sql);
							}
						}
					}
				}
			}
			if(isset($_GET['c_id']))
			{
				$s="select * from cart WHERE c_id='".$_GET['c_id']."'";
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
				$sql = "DELETE FROM cart WHERE c_id='".$_GET['c_id']."'";
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
															<form action="cart.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
									// remove all session variables
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
															<form action="cart.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
															<form action="cart.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
								<form action="cart.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
								<form action="cart.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
								<form action="cart.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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
								<form action="cart.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
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

		<div class="container">	

			<section class="shopping-cart">
			<br><br><br>
			<?php
				$sql = "DELETE FROM cart where quan=0";
				mysqli_query($conn, $sql);
				$s="select * from cart where email='".$_SESSION["email"]."'";
				$result = $conn->query($s);
				if ($result->num_rows!=0) 
				{
					$i=0;
					$c=array();
					$med=array();
					$qu=array();
					while($row = $result->fetch_assoc())
					{ 	
						$c[$i]=$row["c_id"];
						$med[$i]=$row["med_id"];
						$qu[$i]=$row["quan"];
						$i=$i+1;
					}
			?>
			<h2 class="title">Shopping Cart</h2>
			<br>
			<form action="cart.php" role="form"  method="post" enctype="multipart/form-data">
			<table class="items-list" >
			<tbody><tr>
				<th style="padding-bottom:20px;"></th>
			  <th style="padding-bottom:20px;font-size:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Product name</th>
			  <th style="padding-bottom:20px;font-size:20px;">&nbsp;Product price</th>
			  <th style="padding-bottom:20px;font-size:20px;">&nbsp;Quantity</th>
			  <th style="padding-bottom:20px;font-size:20px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</th>
			</tr>
			<?php
				$tt=0;
				for($j=0;$j<$i;$j++)
				{
					$s="select * from medicines where med_id='$med[$j]'";
					$result = $conn->query($s);
					if ($result->num_rows!=0) 
					{	
						if($row = $result->fetch_assoc())
						{
							$m_name=$row["name"];
							$price=$row["price"];
							$pic='img/'.$row["pic"];
						}
					}
					$c_id='cart.php?c_id='.$c[$j];
					$m_id='item.php?p_id='.$med[$j];
					$quan=$qu[$j];
					$total=$quan*$price;
					$tt=$tt+$total;
			?>
					
					<!--Item-->
					<tr class="item">
						<td class="thumb">
							<a href=<?php echo $m_id;?>>
							  <img alt="1" src=<?php echo $pic;?> height="120px" width="140px">
							  <span class="tile-overlay"></span>
							</a>
						</td>
					  <td class="name" style="width:270px;"><a href=<?php echo $m_id;?>><?php echo $m_name;?></a></td>
					  <td class="price" style="width:185px;">BDT <?php echo $price;?> Taka</td>
					  <td class="qnt-count" style="width:130px;">
						<a href="#" class="incr-btn" onclick="decrease('<?php echo $price;?>','<?php echo $m_name;?>','<?php echo $m_id;?>')" style="height:40px;">-</a>
							<input type="text" value=<?php echo $quan;?> class="form-control" id=<?php echo $m_name;?> name=<?php echo $c[$j];?>>
						<a href="#" class="incr-btn" onclick="increase(<?php echo $price;?>,'<?php echo $m_name;?>','<?php echo $m_id;?>')" style="height:40px;">+</a>
					  </td>
					  <td class="price" id='<?php echo $m_id;?>' style="width:165px;">BDT <?php echo $total;?> Taka</td>
					  
					  <td class="delete" style="padding-left:20px;"><a href=<?php echo $c_id;?> style="font-size:1.5em;"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
					</tr>
                   
				  <?php
					}
					?>
					<tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5 style="font-size:15px;">Subtotal</h5></td>
                        <td class="text-right"><input type="text" value=<?php echo $tt;?> class="form-control" id="total1" name="total1" style="text-align:right;"readonly></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h5 style="font-size:15px;">Estimated shipping</h5></td>
                        <td class="text-right"><h5 style="font-size:15px;"><strong style="font-weight:normal;">500 Taka</strong></h5></td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td><h3 style="font-size:30px;">Total</h3></td>
                        <td class="text-right"><h3 style="font-size:30px;" id="total2"><strong style="font-weight:normal;"><?php echo $tt+500; ?> Taka</strong></h3></td>
                    </tr>
				  </tbody></table>
						
						<div class="buttons group" style="padding-bottom:50px;">
							<a role="button" href="medicines.php" class="btn btn-beau" style="height:37px;width:170px;margin-left:10px;"><span class="glyphicon glyphicon-circle-arrow-left"></span>  Continue Shopping&nbsp;</a>
							<!--a role="button" href="cart.php?st=1" class="btn btn-beau" style="height:37px;width:115px;margin-left:10px;">Update</a-->
							<input type="submit" class="btn btn-beau" name="st" value="Update" style="height:37px;width:115px;margin-left:10px;">
							<a class="btn btn-beau" style="height:37px;width:140px;margin-left:10px;margin-left:500px;background-color:black;color:white;" data-toggle="modal" data-target="#modal-3">Checkout  &nbsp;<span class="glyphicon glyphicon-circle-arrow-Right"></span></a>
						</div>
						</form>
						<!--checkout start-->
						<div class="modal fade" id="modal-3" tabindex="-1" role="dialog">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header" style="border-bottom:none">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<br>
										<h1 class="modal-title">Confirmation</h1>
									</div>
									<div class="modal-body" style="border-top:none">
										<h4 style="padding-left:30px;padding-right:10px;">An amount of BDT <?php echo $tt+500;?> Taka will be deducted from your credit card.Do you want to continue?</h4>
										<br><br>
										<form action="cart.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
											<p style="text-align:center;">
												<input type="submit" class="btn btn-beau btn-md" value="Confirm">
												&nbsp;&nbsp;&nbsp;&nbsp;
												<input type="submit" class="btn btn-beau btn-md" value="Cancel" data-dismiss="modal">
											</p>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!--checkout end-->
					<?php
					}
					else
					{
					?>
						<h2 class="title">Shopping Cart is empty!</h2>
						<br><br><br><br><br><br><br><br>
						<?php
					}
				
			
			?>
            <br><br>
      </section>	
		</div><!-- /.container -->
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
		<script src="bootstrap-3.3.2-dist/js/jquery.min.js"></script>
		<script src="bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
		<script src="bootstrap-3.3.2-dist/js/docs.min.js"></script>
		<script src="js/jquery-2.1.3.min.js"></script>
		<script src="js/myjs.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="bootstrap-3.3.2-dist/js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>