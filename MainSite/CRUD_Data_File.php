<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style>
	table {
	    font-family: arial, sans-serif;
	    border-collapse: collapse;
	    width: 100%;
	}

	td, th {
	    border: 1px solid #dddddd;
	    text-align: left;
	    padding: 8px;
	}

	tr:nth-child(even) {
	    background-color: #dddddd;
	}
	</style>
</head>
<body>

</body>
</html>
<?php 
	$con=mysqli_connect("localhost","root","","mainsite") ;


	if($_REQUEST['action']=="select")
	{
		echo "<script src='Crud_Operation.js'></script>";
	}
	
	if($_REQUEST['action']=="insert")
	{
		foreach ($_REQUEST as $key => $value) {
			if($key!="action")
			{
				$insert_arr[$key]=$_REQUEST[$key];
			}
		}
		$Product_Name=$_POST['Product_Name'];
		$Color=$_POST['Color'];
		$Size=$_POST['Size'];
		$Weight=$_POST['Weight'];
		$Manufacturer=$_POST['Manufacturer'];
		$Price=$_POST['Price'];

		$Image = $_FILES['Image']['name'];
		$Image_Loc = $_FILES['Image']['tmp_name'];
 		$folder="E:/wamp64/www/MainSite/Uploads/";
 		move_uploaded_file($Image_Loc,$folder.$Image);

 		$insert_arr['Image']=$Image;
 		$insert_arr['Image_Loc']=$Image_Loc;

		$query="insert into product(Product_Name,Image,Color,Size,Weight,Manufacturer,Price) values('".$Product_Name."','".$Image."','".$Color."','".$Size."',".$Weight.",'".$Manufacturer."',".$Price.")";
		$rs=mysqli_query($con,$query);
		$mid=mysqli_insert_id($con);
		$insert_arr['MainSite_Product_id']=$mid;
		if($rs)
		{
			$encode_insert=json_encode($insert_arr);
			$ch = curl_init('http://localhost/ChildSite/CRUD_Child_Data_File.php');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, $encode_insert);                                    
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			    'Content-Type: application/json',                                                                                
			    'Content-Length: ' . strlen($encode_insert))                                         
			);                                                                                                                   
			$result = curl_exec($ch);
			print_r($result);
		}
		else
		{
			echo $rs;
		}
	}
	
	if($_REQUEST['action']=="delete")
	{
		$pid=$_POST['Product_id'];
		$query="update product set is_delete=1 where Product_id=".$pid;
		$rs=mysqli_query($con,$query);
		if($rs)
		{
			$ch = curl_init('http://localhost/ChildSite/CRUD_Child_Data_File(2).php?action=delete&MainSite_Product_id='.$pid);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");	                                   
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			print_r($result);
		}
	}
	
	if ($_REQUEST['action']=="select") 
	{
		$sql="select * from product";
		$r=mysqli_query($con,$sql);
		echo "<table border=1><tr><th>Product_Name</th><th>	Image</th><th>	Color</th><th>	Size</th><th>	Weight</th><th>	Manufacturer</th><th>Price</th><th>Delete</th><th>Update</th></tr><tr>";
		while($row=mysqli_fetch_assoc($r)){

			if($row['is_delete']==0)
			{
				echo "<tr>
				<td>".$row['Product_Name']."</td>
				<td><img src='http://localhost/MainSite/Uploads/".$row['Image']."' height=50 width=50></td>
				<td>".$row['Color']."</td>
				<td>".$row['Size']."</td>
				<td>".$row['Weight']."</td>
				<td>".$row['Manufacturer']."</td>
				<td>".$row['Price']."</td>
				<td><span><a href='javascript:void(0)' id='".$row['Product_id']."' class=delete title='delete'><img src='http://localhost/MYWORK/Pictures/delete.png' height=48 width=48></a></span></td>
				<td><a href='javascript:void(0)' id='".$row['Product_id']."' class=update_get_data title='update_get_data'><img src='http://localhost/MYWORK/Pictures/Update-icon_48x48.png' height=48 width=48></a></td>
				</tr>";
			}
		}
		echo "</table>";
	}
	
	if ($_REQUEST['action']=="fetch_update_data")
	{
		$pid=$_POST['Product_id'];
		$data = array();
		$query="select * from product where Product_id=".$pid;
		$result=mysqli_query($con,$query);
		while($row=mysqli_fetch_assoc($result))
		{
			$data['Product_id'] = $row['Product_id'];
			$data['Product_Name'] = $row['Product_Name'];
			$data['Image'] = $row['Image'];
			$data['Color'] = $row['Color'];
			$data['Size'] = $row['Size'];
			$data['Weight'] = $row['Weight'];
			$data['Manufacturer'] = $row['Manufacturer'];
			$data['Price'] = $row['Price'];
		}
		echo json_encode($data);
	}
	
	if($_REQUEST['action']=="update_data")
	{
		$update_arr=$_REQUEST;
		$Product_id=$_POST['upProduct_id'];
		$Product_Name=$_POST['upProduct_Name'];
		$Color=$_POST['upColor'];
		$Size=$_POST['upSize'];
		$Weight=$_POST['upWeight'];
		$Manufacturer=$_POST['upManufacturer'];
		$Price=$_POST['upPrice'];
		if($_FILES['upImage']['name']!=null)
		{
			$Image = $_FILES['upImage']['name'];
			$Image_Loc = $_FILES['upImage']['tmp_name'];
 			$folder="E:/wamp64/www/MainSite/Uploads/";
 			move_uploaded_file($Image_Loc,$folder.$Image);
 			$update_arr['upImage']=$Image;
 			$update_arr['upImage_Loc']=$Image_Loc;
		}
		else
		{
			$Image = $_POST['pre_Image'];
			$update_arr['upImage']=$Image;
		}
		
 		print_r($_REQUEST);
 		print_r($update_arr);
 		$query="update product set Product_Name='".$Product_Name."',Image='".$Image."',Color='".$Color."',Size=".$Size.",Weight=".$Weight.",Manufacturer='".$Manufacturer."',Price=".$Price." where Product_id=".$Product_id;
 		$rs=mysqli_query($con,$query);
		if($rs)
		{
			$encode_update=json_encode($update_arr);
			$ch = curl_init('http://localhost/ChildSite/CRUD_Child_Data_File(2).php?action=update_data');
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
			curl_setopt($ch, CURLOPT_POSTFIELDS, $encode_update);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
			    'Content-Type: application/json',                                                                                
			    'Content-Length: ' . strlen($encode_update))                                         
			);                                                                                                                   
			$result = curl_exec($ch);
			print_r($result);
		}
		else
		{
			echo $rs;
		}
	}
 ?>