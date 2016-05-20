<?php
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
							$quan=$_POST['quan'];
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
							$quan=$_POST['quan'];
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