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
		<script src="js/myjs.js"></script>
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
										<li class="active"><a href="adminmed.php" style="font-size:16px;">Medicines</a></li>
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
		<!--\\\\\\\\\\\\\\start//////////////////////////////-->
		
		<div class="container" style="margin-top:40px;">
			<h2>Search for Medicines</h2>
		</div>
		<!--\\\\\\\\\\\\\search bar starts here//////////////-->
		<form role="search" action="adminmed.php" role="form"  method="post" enctype="multipart/form-data">
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
		<!--Approval starts here-->
		<div class="container" >	
			
			<section class="shopping-cart">
			<br><br>
			<?php
				if(isset($_POST['del']))
				{
					$sql = "DELETE FROM medicines WHERE med_id='".$_POST['del']."'";
					mysqli_query($conn, $sql);
				}
				if(isset($_POST['up']))
				{
					$sql = "UPDATE medicines SET name='".$_POST['name']."',type='".$_POST['type']."',ctgry='".$_POST['ctg']."',des='".$_POST['des']."',quan='".$_POST['quan']."',price='".$_POST['price']."' WHERE med_id='".$_POST['up']."'";
					$conn->query($sql);
				}
				$i=0;
				$m_id=array();
				$m_name=array();
				$ctg=array();
				$price=array();
				$pic=array();
				$quan=array();
				$type=array();
				$des=array();
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
									$m_id[$i]=$row["med_id"];
									$m_name[$i]=$row["name"];
									$ctg[$i]=$row["ctgry"];
									$price[$i]=$row["price"];
									$pic[$i]='img/'.$row["pic"];
									$_SESSION["tp"]="med";
									$quan[$i]=$row["quan"];
									$type[$i]=$row["type"];
									$des[$i]=$row["des"];
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
							$m_id[$i]=$row["med_id"];
							$m_name[$i]=$row["name"];
							$ctg[$i]=$row["ctgry"];
							$price[$i]=$row["price"];
							$pic[$i]='img/'.$row["pic"];
							$quan[$i]=$row["quan"];
							$type[$i]=$row["type"];
							$des[$i]=$row["des"];
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
							$m_id[$i]=$row["med_id"];
							$m_name[$i]=$row["name"];
							$ctg[$i]=$row["ctgry"];
							$price[$i]=$row["price"];
							$pic[$i]='img/'.$row["pic"];
							$quan[$i]=$row["quan"];
							$type[$i]=$row["type"];
							$des[$i]=$row["des"];
							$_SESSION["tp"]="med";
							$i=$i+1;
						}
					}
				}
				if($i!=0)
				{
			?>
			<br>
			
			<table class="items-list" id="tblDisplay">
			<tr>
			
				<th style="padding-bottom:20px;"></th>
				<th style="padding-bottom:20px;font-size:20px;text-align:center;">Item Name</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;">Type</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;">Categories</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;">Description</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;">Quantity</th>
			  <th style="padding-bottom:20px;font-size:20px;text-align:center;padding-right:40px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Price</th>
			</tr>
				<tbody>
					<!--Item-->
					<?php
						
						for($j=0;$j<$i;$j++)
						{
								
					?>
					<form action="adminmed.php" role="form"  method="post" enctype="multipart/form-data">
					<tr class="item">
					<td style="padding-left:20px;">
							  <img alt="1" src=<?php echo $pic[$j];?> height="120px" width="120px">
					</td>
					  <td class="qnt-count" style="width:100px;text-align:center; font-size:15px;padding-left:10px;">
						<input type="text" id="name" name="name" value=<?php echo $m_name[$j];?> class="form-control" style="height:33px;width:180px;" >
					</td>
					<td class="qnt-count" style="width:100px;text-align:center; font-size:15px;padding-left:10px;">
						<input type="text" id="type" name="type" value=<?php echo $type[$j];?> class="form-control" style="height:33px;width:140px;" >
					</td>
					<td class="qnt-count" style="width:100px;text-align:center; font-size:15px;">
						<textarea class="form-control" rows="2" id="ctg" name="ctg" maxlength="75"  style="height:33px;width:140px;"><?php echo $ctg[$j];?></textarea>
					</td>
					<td class="qnt-count" style="width:100px;text-align:center; font-size:15px;">
						<textarea class="form-control" rows="4" id="des" name="des" maxlength="75" style="height:150px;width:200px;"><?php echo $des[$j];?></textarea>
					</td>
					<td class="qnt-count" style="width:100px;text-align:center; font-size:15px;">
						<input type="text" id="quan" name="quan" value=<?php echo $quan[$j];?> class="form-control" style="height:33px;width:45px;" >
					</td>
					<td class="qnt-count" style="width:100px;text-align:center; font-size:15px;">
						<input type="text" id="price" name="price" value=<?php echo $price[$j];?> class="form-control" style="height:33px;width:45px;" >
					</td>
					  <td style="font-size:17px;"><button type="submit" class="btn btn-beau" name="up" value=<?php echo $m_id[$j];?> style="height:37px;width:100px;margin-right:10px;">Update</button></td>
					  <td style="font-size:17px;"><button type="submit" class="btn btn-beau" name="del" value=<?php echo $m_id[$j];?> style="height:37px;width:100px;">Delete</button></td>
					  </tr>
					  </form>
					  <?php
						}
					?>
					
						</tbody></table>
						
						
            <br><br>
      </section>	
	  <?php
				}
				else if($t!=0)
				{	
	  ?>
					<h2 class="title">No Item Available!!</h2>
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