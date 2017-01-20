<?php
	$con=mysqli_connect("localhost","root","","test_13");
	if($_REQUEST['action']=="select")
	{
		$sql="select * from owlcarousel";
		$r=mysqli_query($con,$sql);
		while ($rs=mysqli_fetch_assoc($r)) 
		{
			$img[]=$rs;
		}
		echo json_encode($img);
	}
	if($_REQUEST['action']=="insert")
	{
		$Image = $_FILES['addItem']['name'];
		$Image_Loc = $_FILES['addItem']['tmp_name'];
 		$folder="E:/wamp64/www/partsSearch/Pictures/";
 		move_uploaded_file($Image_Loc,$folder.$Image);
 		$sql="insert into owlcarousel values('".$Image."')";
 		$r=mysqli_query($con,$sql);
 		echo $r;
	}
?>