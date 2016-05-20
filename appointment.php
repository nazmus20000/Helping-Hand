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
		<script src="bootstrap-3.3.2-dist/js/jquery.min.js"></script>
		<script src="js/jquery-1.7.1.min.js"></script>
		<script src="js/myjs.js"></script>
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
		<script language="javascript" type="text/javascript">
			$(document).ready(function(){
				$('input[type="checkbox"]').on('change', function(){
					$('input[name="' + this.name + '"]').not(this).prop('checked', false);
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
					<li class="active"><a href="index.php" style="font-size:16px;">Home</a></li>
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
								
								if(isset($_POST['logout']))
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
															<form action="dpanel.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
																<p style="text-align:center;"><input name="logout" type="submit" class="btn btn-success" value="Sign Out"></p>
															</form>
														</li>
													</ul>
												</li>
											</ul>
							<?php
								}
							?>
						</div>
					</div>
				</nav>	
			</div>
		</div>
		
		<!--\\\\\\\\\\\\\Navigation ber ends here/////////////-->
		
		<!--appointment starts here-->
		<?php
			$emm=$_SESSION["email"];
			$pw=$_SESSION["password"];
			$user=$_SESSION["username"];
			if(isset($_POST['appointment']))
			{
				$_SESSION["appointment"]=$_POST['appointment'];
			}
			$s="select name from doctors where d_id='".$_SESSION["appointment"]."'";
			$result = $conn->query($s);
			if ($result->num_rows!=0) 
			{
				if($row = $result->fetch_assoc())
				{
					$name=$row["name"];
				}
			}
			if(isset($_POST['st']))
			{
				if(isset($_POST['visit']))
				{
					$s="select serial from appointment where v_id='".$_POST['visit']."'";
					$result = $conn->query($s);
					$serial=1;
					if ($result->num_rows!=0) 
					{
						while($row = $result->fetch_assoc())
						{
							$serial=$row["serial"];
						}
						$serial=$serial+1;
					}
					$s="select v_id from visiting_hours where d_id='".$_SESSION["appointment"]."'";
					$result = $conn->query($s);
					$i=0;
					$vv_id=array();
					if ($result->num_rows!=0) 
					{
						while($row = $result->fetch_assoc())
						{
							$vv_id[$i]=$row["v_id"];
							$i=$i+1;
						}
					}
					$t=0;
					$a_id=0;
					for($j=0;$j<$i;$j++)
					{
						$s="select * from appointment where v_id='".$vv_id[$j]."' and email='$emm'";
						$result1 = $conn->query($s);
						if ($result1->num_rows!=0) 
						{
							if($row1 = $result1->fetch_assoc())
							{
								$a_id=$row1["a_id"];
							}
							$t=1;
							break;
						}
					}
					if($t==1)
					{
						$sql = "DELETE FROM appointment WHERE a_id='$a_id'";
						mysqli_query($conn, $sql);
					}
					$s="INSERT INTO appointment (v_id,serial,email) VALUES('".$_POST['visit']."','$serial','$emm')";
					$conn->query($s);
				}
			}
		?>
		<div class="container">	
			
			<section class="shopping-cart">
			<br><br><br>
			<?php
				$s="select * from visiting_hours where d_id='".$_SESSION["appointment"]."'";
				$result = $conn->query($s);
				if ($result->num_rows!=0) 
				{
			?>
			<div class="page-header">
				<div class="container" style="margin-top:40px;">
					<h2 style="color:#3eb4e5;"><?php echo $name;?> Visiting Hours</h2>
					<br>
				</div>
			</div>
			<br>
			<form action="appointment.php" role="form"  method="post" enctype="multipart/form-data">
			<table class="items-list" id="tblDisplay">
			<tr>
			
				<th style="padding-bottom:20px;"></th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;">Day</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;">Starting Time</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;">Ending Time</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;">Booked</th>
			</tr>
				<tbody>
					<!--Item-->
					<?php
						
						while($row = $result->fetch_assoc())
						{
							$v_id=$row["v_id"];
							$day=$row["day"];
							$s_time=$row["s_time"]." ".$row["s_st"];
							$e_time=$row["e_time"]." ".$row["e_st"];
							$limit=$row["c_limit"];
							$s="select * from appointment where v_id='".$row["v_id"]."'";
							$result1 = $conn->query($s);
							$cnt=0;
							if ($result1->num_rows!=0) 
							{
								while($row1 = $result1->fetch_assoc())
								{
									$cnt=$cnt+1;
								}
							}
							$booked=$cnt;
							$s="select * from appointment where v_id='".$row["v_id"]."' and email='$emm'";
							$result1 = $conn->query($s);
							if ($result1->num_rows!=0) 
							{
								
					?>
					<tr class="item">
					  <td style="width:100px;">
							<input type="checkbox" name="visit" value=<?php echo $v_id;?> checked>
						</td>
						<?php
							}
							else
							{
						?>
					<tr class="item">
					  <td style="width:100px;">
							<input type="checkbox" name="visit" value=<?php echo $v_id;?>>
						</td>
						<?php
							}
						?>
					  <td style="width:150px;text-align:center;"><?php echo $day;?></td>
					  <td style="width:100px;text-align:center;font-size:15px;"><?php echo $s_time;?></td>
					  <td style="width:100px;text-align:center;font-size:15px;"><?php echo $e_time;?></td>
					  <td style="width:100px;text-align:center;"><?php echo $booked?>/<?php echo $limit;?></td>
					  </tr>
					  <?php
						}
					?>
					
						</tbody></table>
						<div class="buttons group" style="padding-bottom:50px;">
							<button type="submit" class="btn btn-beau" name="st" value="st" style="height:37px;width:180px;margin-left:40%;">Update Visiting Hour</button>
						</div>
						
						</form>
            <br><br>
      </section>	
	  <?php
				}
				else
				{	
	  ?>
					<h2 class="title">No visiting hours available for <?php echo $name;?> !!</h2>
					<br><br><br><br><br><br><br><br>
	  <?php
				}
	  ?>
		</div><!-- /.container -->
		<!--appointment ends here-->
		
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
		<script src="bootstrap-3.3.2-dist/js/bootstrap.min.js"></script>
		<script src="bootstrap-3.3.2-dist/js/docs.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script src="bootstrap-3.3.2-dist/js/ie10-viewport-bug-workaround.js"></script>
	</body>
</html>