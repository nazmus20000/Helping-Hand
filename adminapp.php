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
			$(document).ready(function()
			{
				$("#checkall").live('click',function(event){
					$('input:checkbox:not(#checkall)').attr('checked',this.checked);
					//To Highlight
					if ($(this).attr("checked") == true)
					{
						//$(this).parents('table:eq(0)').find('tr:not(#chkrow)').css("background-color","#FF3700");
						$("#tblDisplay").find('tr:not(#chkrow)').css("background-color","#c6c3c3");
					}
					else
					{
						//$(this).parents('table:eq(0)').find('tr:not(#chkrow)').css("background-color","#fff");
						$("#tblDisplay").find('tr:not(#chkrow)').css("background-color","#FFF");
					}
				});
				$('input:checkbox:not(#checkall)').live('click',function(event){
					if($("#checkall").attr('checked') == true && this.checked == false)
					{
						$("#checkall").attr('checked',false);
						$(this).closest('tr').css("background-color","#c6c3c3");
					}
					if(this.checked == true)
					{
						$(this).closest('tr').css("background-color","#c6c3c3");
						CheckSelectAll();
					}
					if(this.checked == false)
					{
						$(this).closest('tr').css("background-color","#ffffff");
					}
				});

				function CheckSelectAll(){
					var flag = true;
					$('input:checkbox:not(#checkall)').each(function(){
						if(this.checked == false)
						flag = false;
					});
					$("#checkall").attr('checked',flag);
					}
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
		if(isset($_POST['logout']))
		{
			// remove all session variables
			session_unset();

			// destroy the session
			session_destroy(); 
			header('Location: adminlogin.php');
		}
		$s="select * from notification where rec='admin' and status=''";
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
							<ul class="nav navbar-nav">
								<li class="active"><a href="adminapp.php" style="font-size:16px;">Approval</a></li>
								<li><a href="adminuser.php" style="font-size:16px;">All Users</a></li>
								<li class="dropdown">
									<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" style="font-size:16px;">Items<span class="caret"></span></a>
									<ul role="menu" class="dropdown-menu">
										<li><a href="adminmed.php" style="font-size:16px;">Medicines</a></li>
									</ul>
								</li>
								<li><a href="adminmsg.php" style="font-size:16px;"><span class="glyphicon glyphicon-envelope" ></span> Message <span class="badge"style="font-size:12px;"><?php echo $cnt1;?></span></a></li>
							</ul>
							<ul class="nav navbar-nav navbar-right">
								<li class="dropdown">
									<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" style="font-size:16px;">Admin<span class="caret"></span></a>
									<ul role="menu" class="dropdown-menu">
										<li>
											<form action="adminapp.php" role="form" class="form-inline" method="post" enctype="multipart/form-data">
												<p style="text-align:center;margin-top:20px;"><input name="logout" type="submit" class="btn btn-success" value="Sign Out"></p>
											</form>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</nav>	
			</div>
		</div>
		
		<!--\\\\\\\\\\\\\Navigation ber ends here/////////////-->
		
		<!--Approval starts here-->
		<div class="container">	
			
			<section class="shopping-cart">
			<br><br>
			<?php
				if(isset($_POST['st']))
				{
					$cnt=count($_POST['visit']);
					for($i=0;$i<$cnt;$i++)
					{
						$s="select * from approval where o_id='".$_POST['visit'][$i]."'";
						$result = $conn->query($s);
						if ($result->num_rows!=0) 
						{
							$date=date("d/m/Y H:i:s");
							if($row = $result->fetch_assoc())
							{
								$o_id=$row['o_id'];
								$mml=$row['email'];
								$name=$row['name'];
								$quan=$row['quan'];
								$price=$row['price'];
								$mm=$quan." ".$name." will be delivered within 7 days.An amount ".$price." of has been deducted from your credit card.";
								$s="INSERT INTO notification (send,rec,message,date) VALUES('admin','$mml','$mm','$date')";
								$conn->query($s);
								$s="UPDATE approval SET stat='Approved' where o_id='$o_id'";
								$conn->query($s);
							}
						}
					}
				}
				if(isset($_POST['st1']))
				{
					$s="select * from approval where o_id='".$_POST['st1']."'";
					$result = $conn->query($s);
					if ($result->num_rows!=0) 
					{
						$date=date("d/m/Y H:i:s");
						if($row = $result->fetch_assoc())
						{
							$o_id=$row['o_id'];
							$mml=$row['email'];
							$name=$row['name'];
							$quan=$row['quan'];
							$price=$row['price'];
							$mm=$quan." ".$name." will be delivered within 7 days.An amount ".$price." of has been deducted from your credit card.";
							$s="INSERT INTO notification (send,rec,message,date) VALUES('admin','$mml','$mm','$date')";
							$conn->query($s);
							$s="UPDATE approval SET stat='Approved' where o_id='$o_id'";
							$conn->query($s);
						}
					}
				}
				if(isset($_POST['st2']))
				{
					$s="select * from approval where stat=''";
					$result = $conn->query($s);
					if ($result->num_rows!=0) 
					{
						$date=date("d/m/Y H:i:s");
						while($row = $result->fetch_assoc())
						{
							$o_id=$row['o_id'];
							$mml=$row['email'];
							$name=$row['name'];
							$quan=$row['quan'];
							$price=$row['price'];
							$mm=$quan." ".$name." will be delivered within 7 days.An amount ".$price." of has been deducted from your credit card.";
							$s="INSERT INTO notification (send,rec,message,date) VALUES('admin','$mml','$mm','$date')";
							$conn->query($s);
							$s="UPDATE approval SET stat='Approved' where o_id='$o_id'";
							$conn->query($s);
						}
					}
				}
				$s="select * from approval where stat=''";
				$result = $conn->query($s);
				if ($result->num_rows!=0) 
				{
			?>
			<div class="page-header">
				<div class="container">
					<h2 style="color:#3eb4e5;">Approvals</h2>
					<form action="adminapp.php" role="form"  method="post" enctype="multipart/form-data">
					<button type="submit" class="btn btn-beau" name="st2" value="st" style="height:37px;width:100px;margin-left:40%;">Approve All</button>
					</form>
					<br>
				</div>
			</div>
			<br>
			<form action="adminapp.php" role="form"  method="post" enctype="multipart/form-data">
			<table class="items-list" id="tblDisplay">
			<tr>
			
				<th style="padding-bottom:20px;"></th>
				<th style="padding-bottom:20px;"></th>
				<th style="padding-bottom:20px;font-size:20px;text-align:center;">Email</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;">Name</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;">Quantity</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;">Price</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;padding-right:40px;">Date</th>
			</tr>
				<tbody>
					<!--Item-->
					<?php
						
						while($row = $result->fetch_assoc())
						{
							$o_id=$row['o_id'];
							$mml=$row['email'];
							$name=$row['name'];
							$quan=$row['quan'];
							$date=$row['date'];
							$price=$row['price'];
							$pic='img/'.$row["pic"];
								
					?>
					<tr class="item">
					<td>
							<input type="checkbox" name="visit[]" value=<?php echo $o_id;?>>
						</td>
					<td style="padding-left:20px;">
							  <img alt="1" src=<?php echo $pic;?> height="120px" width="140px">
					</td>
					  <td style="width:150px;text-align:center;font-size:17px;"><?php echo $mml;?></td>
					  <td style="width:150px;text-align:center;font-size:17px;"><?php echo $name;?></td>
					  <td style="width:100px;text-align:center;font-size:17px;"><?php echo $quan;?></td>
					  <td style="width:100px;text-align:center;font-size:17px;"><?php echo $price;?></td>
					  <td style="width:100px;text-align:center;font-size:17px;padding-right:80px;padding-left:50px;"><?php echo $date;?></td>
					  <td style="font-size:17px;"><button type="submit" class="btn btn-beau" name="st1" value=<?php echo $o_id;?> style="height:37px;width:100px;">Approve</button></td>
					  </tr>
					  <?php
						}
					?>
					
						</tbody></table>
						<br><br>
						<div class="buttons group" style="padding-bottom:50px;">
							<button type="submit" class="btn btn-beau" name="st" value="st" style="height:37px;width:100px;margin-left:42%;">Approve</button>
						</div>
						
						</form>
            <br><br>
      </section>	
	  <?php
				}
				else
				{	
	  ?>
					<h2 class="title">No Pending orders!!</h2>
					<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
	  <?php
				}
	  ?>
		</div><!-- /.container -->
		<!--Approval ends here-->
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