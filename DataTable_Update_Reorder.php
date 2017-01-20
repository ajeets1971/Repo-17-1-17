<?php
	$con=mysqli_connect("localhost","root","","test_13");
	if($_REQUEST['action']=="order")
	{
		$str= json_decode($_REQUEST['reorder']);	
		//print_r($str);
		$sql="select * from prod";
		$r=mysqli_query($con,$sql);
		
		while ($rs=mysqli_fetch_assoc($r))
		{
			$j=0;
			while ($j<count($str)) 
			{
				if($rs['Product_Name']==$str[$j][1] && $rs['Color']==$str[$j][2] && $rs['Size']==$str[$j][3] && $rs['Weight']==$str[$j][4] && $rs['Manufacturer']==$str[$j][5] && $rs['Price']==$str[$j][6])
				{
					//echo "Found ". $str[$j][0] . $rs['Product_id'];
					/*print_r($rs);
					print_r($str[$j]);*/
					$sql1="UPDATE prod SET ReOrder=".$str[$j][0]." WHERE Product_id=".$rs['Product_id'];
					$r1=mysqli_query($con,$sql1);
				}
				$j++;
			}
		}
	}
	if($_REQUEST['action']=="delete")
	{
		$dlt_str= json_decode($_REQUEST['dlt_rec']);
		$query="UPDATE prod SET is_delete=1 WHERE ReOrder=".$dlt_str[0];
		echo $query;
		$r1=mysqli_query($con,$query);
	}
	if($_REQUEST['action']=="Update_getData")
	{
		$up_str= json_decode($_REQUEST['up_rec']);
		$sql="select * from prod where is_delete=0 and ReOrder=".$up_str[0];
		$r=mysqli_query($con,$sql);
		while ($rs=mysqli_fetch_assoc($r))
		{
			$up_rec=$rs;
		}
		echo json_encode($up_rec);
	}
	if($_REQUEST['action']=="update_data")
	{
		print_r($_POST);
		$Product_id=$_POST['upProduct_id'];
		$Product_Name=$_POST['upProduct_Name'];
		$Color=$_POST['upColor'];
		$Size=$_POST['upSize'];
		$Weight=$_POST['upWeight'];
		$Manufacturer=$_POST['upManufacturer'];
		$Price=$_POST['upPrice'];
 		$query="update prod set Product_Name='".$Product_Name."',Color='".$Color."',Size=".$Size.",Weight=".$Weight.",Manufacturer='".$Manufacturer."',Price=".$Price." where Product_id=".$Product_id;
 		$rs=mysqli_query($con,$query);
 	}
 	
 	if($_REQUEST['action']=="insert_data")
	{
		$Product_Name=$_POST['InProduct_Name'];
		$Color=$_POST['InColor'];
		$Size=$_POST['InSize'];
		$Weight=$_POST['InWeight'];
		$Manufacturer=$_POST['InManufacturer'];
		$Price=$_POST['InPrice'];
		print_r($_POST);
		$query="insert into prod(Product_Name,Color,Size,Weight,Manufacturer,Price,ReOrder,is_delete) values('".$Product_Name."','".$Color."','".$Size."',".$Weight.",'".$Manufacturer."',".$Price.",0,0)";
		$rs=mysqli_query($con,$query);
		echo $rs;
	}

?>