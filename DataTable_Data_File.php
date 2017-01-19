<?php
	$con=mysqli_connect("localhost","root","","test_13");
	if(isset($_REQUEST['getProduct']))
	{
		$columns=array(
			0=>'Product_id',
			1=>'Product_Name',
			2=>'Color',
			3=>'Size',
			4=>'Weight',
			5=>'Manufacturer',
			6=>'Price');
		$Json['aaData'] = array();
		
		$total_data=mysqli_query($con,"select count(*) as total from prod");
		$total=mysqli_fetch_array($total_data);
		$sql="select * from prod";
		if( !empty($_REQUEST['sSearch'])){// if there is a search parameter, $requestData['search']['value'] contains search parameter
	        $sql.=" Where ( Product_Name LIKE '".$_REQUEST['sSearch']."%' ";    
	        $sql.=" OR Price LIKE '".$_REQUEST['sSearch']."%' )";
	        // $sql.=" OR employee_age LIKE '".$_REQUEST['sSearch']."%' )";
	    }
	    if( isset( $_REQUEST['iSortCol_0'] )  && isset($_REQUEST['sSortDir_0']))
	    {
	    	$sql .= " Order by ".$columns[$_REQUEST['iSortCol_0']] ." ". $_REQUEST['sSortDir_0'];
	    }
	    if ( isset( $_REQUEST['iDisplayStart'] ) && $_REQUEST['iDisplayLength'] != '-1' )
	    {
	            $sql.= " LIMIT ".$_REQUEST['iDisplayStart'].", ".$_REQUEST['iDisplayLength'];
	    }
	     // echo $sql;
		$r=mysqli_query($con,$sql);
		$k=0;
		$seq=1;
		while($row=mysqli_fetch_assoc($r))
		{
			$Json['aaData'][$k][]=$seq;
			$Json['aaData'][$k][]=$row['Product_Name'];
			$Json['aaData'][$k][]=$row['Color'];
			$Json['aaData'][$k][]=$row['Size'];
			$Json['aaData'][$k][]=$row['Weight'];
			$Json['aaData'][$k][]=$row['Manufacturer'];
			$Json['aaData'][$k][]=$row['Price'];
			$k++;
			$seq++;
		}
		$Json['iTotalDisplayRecords'] = $total['total'];
		$Json['sEcho'] =null;
	    echo json_encode($Json);
	}
	
?>                           
	
