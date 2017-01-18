<?php
	$con=mysqli_connect("localhost","root","","test_13") ;

	$insert_json=file_get_contents('php://input');
	$insert_arr=json_decode($insert_json);
	print_r($insert_arr);
	$Product_Name=$insert_arr->Product_Name;
	$Image=$insert_arr->Image;
	$Color=$insert_arr->Color;
	$Size=$insert_arr->Size;
	$Weight=$insert_arr->Weight;
	$Manufacturer=$insert_arr->Manufacturer;
	$Price=$insert_arr->Price;
	$Image_Loc=$insert_arr->Image_Loc;
	$MainSite_Product_id=$insert_arr->MainSite_Product_id;

	$folder="E:/wamp64/www/ChildSite/Uploads/";
 	//move_uploaded_file($Image_Loc,$folder.$Image);
 	copy("E:/wamp64/www/MainSite/Uploads/".$Image,$folder.$Image);

	$query="insert into product(MainSite_Product_id,Product_Name,Image,Color,Size,Weight,Manufacturer,Price) values(".$MainSite_Product_id.",'".$Product_Name."','".$Image."','".$Color."','".$Size."',".$Weight.",'".$Manufacturer."',".$Price.")";
	$rs=mysqli_query($con,$query);
	echo $rs;
?>

