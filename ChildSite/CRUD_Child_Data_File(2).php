<?php	
	$con=mysqli_connect("localhost","root","","test_13") ;

	if($_REQUEST['action']=="delete")
	{
		echo "Message from child ".$_REQUEST['MainSite_Product_id'];
		$pid=$_REQUEST['MainSite_Product_id'];
		$query="update product set is_delete=1 where MainSite_Product_id=".$pid;
		$rs=mysqli_query($con,$query);
		echo $rs;
	}
	if($_REQUEST['action']=="update_data")
	{
		$update_json=file_get_contents('php://input');
		$update_arr=json_decode($update_json);
		print_r($update_arr);
		$Product_Name=$update_arr->upProduct_Name;
		$Image=$update_arr->upImage;
		$Color=$update_arr->upColor;
		$Size=$update_arr->upSize;
		$Weight=$update_arr->upWeight;
		$Manufacturer=$update_arr->upManufacturer;
		$Price=$update_arr->upPrice;
		$Image_Loc=$update_arr->upImage_Loc;
		$MainSite_Product_id=$update_arr->upProduct_id;

		$folder="E:/wamp64/www/ChildSite/Uploads/";
	 	//move_uploaded_file($Image_Loc,$folder.$Image);
	 	copy("E:/wamp64/www/MainSite/Uploads/".$Image,$folder.$Image);

		$query="update product set Product_Name='".$Product_Name."',Image='".$Image."',Color='".$Color."',Size=".$Size.",Weight=".$Weight.",Manufacturer='".$Manufacturer."',Price=".$Price." where MainSite_Product_id=".$MainSite_Product_id;
		$rs=mysqli_query($con,$query);
		echo $rs;
	}
?>