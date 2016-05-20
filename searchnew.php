<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Wish Gadgets</title>
	<meta name="description" content="A product presentation page built for a Tuts+ course">
	<meta name="author" content="Adi Purdila">

	<!-- Mobile Specific Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
	<!-- Bootstrap files -->
	<!-- Latest compiled and minified CSS -->
	<!-- Bootstrap CSS -->
		<link href="includes/css/bootstrap-glyphicons.css" rel="stylesheet">
		
		<!-- Custom CSS -->
		<link rel="stylesheet" href="includes/css/styles.css">
		<lik rel="styleheet" href="cerulean-bootstrap-theme.css">
		
		<link rel="stylesheet" href="assets/style.css">
		<lin rel="stylesheet" href="cerulean-bootstrap-theme-normal.css">
		<lnk rel="stylesheet" href="bootstrap/css/bootstrap.min.css" >
		<lnk rel="stylesheet" href="Bootstrap practice/css/bootstrap.min.css" >
		
	<lnk rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="Bootstrap practice/css/bootstrap_united.css" >
		 <link rel="stylesheet" href="dist/css/formValidation.css"/>
		 <link rel="stylesheet" href="css/mycustom.css"/>

		
	<!--	<link rel="stylesheet" href="custom.css">
	
	
		
		<!-- Include Modernizr in the head, before any other Javascript -->
		<script src="includes/js/modernizr-2.6.2.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="dist/js/formValidation.js"></script>
    <script type="text/javascript" src="dist/js/framework/bootstrap.js"></script>
				
	<link rel="stylesheet" href="assets/css/jquery-ui.min.css">
	<script type="text/javascript" src="vendor/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/jquery-ui.min.js"></script>
	<script>
	$(document).ready(function(){
			$("#query").autocomplete({
				source: 'Admin/autocomp.php',
				select: function(event,ui)
				{
					$("#result").html(ui.item.value);
				}
			});
			});
		
	</script>

	<!-- Optional theme -->
	<!-- <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css"> -->
	
</head>
<body>


  <?php
  include "header.php";
  ?>

<br><br><br>
		
<div class="container" >


			
			
			
								
			<?php include "login_modal.php";?>
	
			


	
	<div class="row">
	
	<?php
	$servername = "localhost";
$user = "root";			
$password = "";
$dbname = "wish_gadgets";

// Create connection	
$conn = new mysqli($servername, $user, $password, $dbname);
// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
$q=$_POST['search'];
$s="select * from products where item_name='$q'";
$result = $conn->query($s);
$data=array();
if ($result->num_rows!=0) 
{
	if($row = $result->fetch_assoc())
	{ 
		$itemId=$row['item_id'];
$Id=$row['category_id'];
$ItemName=$row['item_name'];
$Description=$row['item_description'];

$Image=$row['item_image'];
$price=$row['item_price'];
$discount=$row['item_discount'];
$total=$row['item_total'];
	
	
	?>
	
	                        <div class="col-sm-3">
                            <div class="col-item">
                                <div class="photo">
                                    <img src="Products/<?php echo $ItemName; ?>/<?php echo $Image;?>"  style="height: 200px; width: 250px" class="responsive" alt="a" />
                                </div>
                                <div class="info">
                                    <div class="row">
                                        <div class="price col-md-6">
                                            <h5>
                                                Product with Variants</h5>
                                            <h5 class="price-text-color">
                                                <?php echo $price; ?></h5>
                                        </div>
                                        <div class="rating hidden-sm col-md-6">
                                            <i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="price-text-color fa fa-star"></i><i class="price-text-color fa fa-star">
                                            </i><i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="separator clear-left">
                                        <p class="btn-add"><button class="btn btn-success"> <i class="fa fa-shopping-cart"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm " style="color: white">Add to cart</a></button></p>
                                        <p class="btn-details">
                                            <button class="btn btn-info"> <i class="fa fa-list"></i><a href="http://www.jquery2dotnet.com" class="hidden-sm"style="color: white" >More details</a></button></p>
                                    </div>
                                    <div class="clearfix">
                                    </div>
                                </div>
                            </div>
							
				</br>
                        </div>
						
		
		<?php 
		
			}
			
}
else
{	
	echo "khuje pai na";		
}

			
			
	mysqli_close($conn);
			
		?>
						
							
						
	</div>
	
	
	
	
	
				
					
					
	


					
					
  
</div>


	  <?php
  include "footer.php";
  ?>
	

	<!-- All Javascript at the bottom of the page for faster page loading -->
		
	<!-- First try for the online version of jQuery-->
	<!-- If no online access, fallback to our hardcoded version of jQuery -->
	<script>window.jQuery || document.write('<script src="includes/js/jquery-1.8.2.min.js"><\/script>')</script>
	
	<!-- Bootstrap JS -->
	<!-- Custom JS -->
	<scrpt src="includes/js/script.js"></script>
	
	

	<script>
	$(document).ready(function(){
    $(".dropdown").hover(            
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideDown("fast");
            $(this).toggleClass('open');        
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).slideUp("fast");
            $(this).toggleClass('open');       
        }
    );
});
	
	</script>

</body>
</html>