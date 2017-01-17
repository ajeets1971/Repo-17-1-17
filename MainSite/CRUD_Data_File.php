
<?php 
$con=mysqli_connect("localhost","root","","mainsite") ;

	if($_REQUEST['action']=="select")
	{
		echo "<script src='CRUD_Operations.js'></script>";
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
		$eid=$_POST['employee_id'];
		$query="delete from users where employee_id=".$eid;
		$rs=mysqli_query($con,$query);
		if($rs)
		{
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
	}
	
	if ($_REQUEST['action']=="select") 
	{
		$sql="select * from product";
		$r=mysqli_query($con,$sql);
		echo "<table border=1><tr><td>Product_Name</td><td>	Image</td><td>	Color</td><td>	Size</td><td>	Weight</td><td>	Manufacturer</td><td>Price</td><td>Delete</td><td>Update</td></tr><tr>";
		while($row=mysqli_fetch_assoc($r)){
			echo "<tr>
			<td>".$row['Product_Name']."</td>
			<td><img src='http://localhost/MainSite/Uploads/".$row['Image']."' height=50 width=50></td>
			<td>".$row['Color']."</td>
			<td>".$row['Size']."</td>
			<td>".$row['Weight']."</td>
			<td>".$row['Manufacturer']."</td>
			<td>".$row['Price']."</td>
			<td><span><a href='javascript:void(0)' id='".$row['Product_id']."' class=delete title='delete'><img src=' http://localhost/MYWORK/Pictures/delete.png' height=48 width=48></a></span></td>
			<td><a href='javascript:void(0)' id='".$row['Product_id']."' class=update_get_data title='update_get_data'><img src='http://localhost/MYWORK/Pictures/Update-icon_48x48.png' height=48 width=48></a></td>
			</tr>";
		}
		echo "</table>";
	}
	
	if ($_REQUEST['action']=="fetch_update_data")
	{
		$eid=$_POST['employee_id'];
		$data = array();
		$query="select *  from users where employee_id=".$eid;
		$result=mysqli_query($con,$query);
		while($row=mysqli_fetch_assoc($result))
		{
			$data['employee_id'] = $row['employee_id'];
			$data['employee_name'] = $row['employee_name'];
			$data['email'] = $row['email'];
			$data['hired_date'] = $row['hired_date'];
			$data['salary'] = $row['salary'];
		}
		echo json_encode($data);
	}
	
	if($_REQUEST['action']=="update")
	{
		$eid=$_POST['employee_id'];
		$ename=$_POST['empname'];
		$salary=$_POST['salary'];	
		$query="update users set employee_name='".$ename."',salary='".$salary."' where employee_id=".$eid;
		$result=mysqli_query($con,$query);
	}
 ?>