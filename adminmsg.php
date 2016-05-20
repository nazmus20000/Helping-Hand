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
			if(isset($_GET['n_id']))
			{
				$sql = "DELETE FROM notification WHERE n_id='".$_GET['n_id']."'";
				mysqli_query($conn, $sql);
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
								<li><a href="adminapp.php" style="font-size:16px;">Approval</a></li>
								<li><a href="adminuser.php" style="font-size:16px;">All Users</a></li>
								<li class="dropdown">
									<a aria-expanded="false" role="button" data-toggle="dropdown" class="dropdown-toggle" href="#" style="font-size:16px;">Items<span class="caret"></span></a>
									<ul role="menu" class="dropdown-menu">
										<li><a href="adminmed.php" style="font-size:16px;">Medicines</a></li>
									</ul>
								</li>
								<li class="active"><a href="adminmsg.php" style="font-size:16px;"><span class="glyphicon glyphicon-envelope" ></span> Message <span class="badge"style="font-size:12px;"><?php echo $cnt1;?></span></a></li>
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
		
		<!-- Marketing messaging and featurettes
		================================================== -->
		<!-- Wrap the rest of the page in another container to center all the content. -->

		<div class="container">	

			<section class="shopping-cart">
			<br><br><br>
			<?php
				$s="select * from notification where rec='admin' ORDER BY n_id DESC";
				$result = $conn->query($s);
				if ($result->num_rows!=0) 
				{
			?>
			<h2 class="title">Messages</h2>
			<br><br>
			<form action="adminmsg.php" role="form"  method="post" enctype="multipart/form-data">
			<table class="items-list" >
			<tr>
			
				
			  <th style="padding-bottom:20px;font-size:20px;">From</th>
			  <th style="padding-bottom:20px;font-size:20px;padding-left:60px;">Message</th>
			</tr>
			<tbody>
			<?php
				while($row = $result->fetch_assoc())
				{ 	
					$temp=$row["n_id"];
					$n_id='adminmsg.php?n_id='.$temp;
					$msg=$row["message"];
					$sts=$row["status"];
					$date=$row["date"];
					$send=$row["send"];
					if($sts=="")
					{
						$sql="UPDATE notification SET status='Seen' WHERE n_id='$temp'";
						$conn->query($sql);
			?>
					
					<!--Item-->
					<tr class="item">
					  <td class="name" bgcolor="#c6c3c3">
					  <p style="font-size:16px;"><?php echo $send;?></p>
					  </td>
					  <td class="name" bgcolor="#c6c3c3">
					  <p style="font-size:16px;padding-left:60px;"><?php echo $msg;?></p>
					  <p style="font-size:12px;padding-left:60px;"><?php echo $date;?></p>
					  </td>
					  
					  <td class="delete" style="padding-left:20px;"><a href=<?php echo $n_id;?> style="font-size:1.5em;"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
					</tr>
                   
				  <?php
					}
					else
					{
					?>
					<!--Item-->
					<tr class="item">
					  <td class="name">
					  <p style="font-size:16px;"><?php echo $send;?></p>
					  </td>
					  <td class="name">
					  <p style="font-size:16px;padding-left:60px;"><?php echo $msg;?></p>
					  <p style="font-size:12px;padding-left:60px;"><?php echo $date;?></p>
					  </td>
					  
					  <td class="delete" ><a href=<?php echo $n_id;?> style="font-size:1.5em;"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
					</tr>
					<?php
					}
				}
					?>
				  </tbody></table>
					<?php
				}
					else
					{
					?>
						<h2 class="title">No Message!</h2>
						<br><br><br><br><br><br><br><br>
						<?php
					}
				
			
			?>
            <br><br>
      </section>	
		</div><!-- /.container -->
		
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