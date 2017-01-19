<?php
$con=mysqli_connect("localhost","root","","test_13");
$sql="select * from product";
$r=mysqli_query($con,$sql);
$k=0;
while($row=mysqli_fetch_assoc($r))
{
	$Json['data'][$k][]=$row['Product_id'];
	$Json['data'][$k][]=$row['Product_Name'];
	$Json['data'][$k][]=$row['Color'];
	$Json['data'][$k][]=$row['Size'];
	$Json['data'][$k][]=$row['Weight'];
	$Json['data'][$k][]=$row['Manufacturer'];
	$Json['data'][$k][]=$row['Price'];
	$k++;
}
echo json_encode($Json);
?>