<?php
	$con=mysqli_connect("localhost","root","","test_13");
	$sql="select Product_Name,Image,Color,Size,Weight,Manufacturer,Price from product order by Product_Name";
	$r=mysqli_query($con,$sql);
	while($row=mysqli_fetch_assoc($r))
	{
		$auto_com[]=$row;
	}
	echo json_encode($auto_com);
?>                           
	
