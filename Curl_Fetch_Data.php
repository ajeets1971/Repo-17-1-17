<?php
	$url='http://localhost/repo-17-1-17/Fetch_Product_Data_File.php';
	$curl=curl_init($url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$curl_response=curl_exec($curl);
	curl_close($curl);
	if($curl_response!=false)
	{
		$data=json_decode($curl_response);
		echo "<table border=1><tr><td>Product_Name</td><td>	Image</td><td>	Color</td><td>	Size</td><td>	Weight</td><td>	Manufacturer</td><td>Price</td></tr><tr>";
		foreach ($data as $key => $value) {
			foreach ($value as $key => $value) {
				if($key=="Image")
				{
					echo "<td><img src=".$value." height=50 width=50></td>";
				}
				else
				{
					echo "<td>".$value."</td>";
				}
			}
			echo "</tr>";
		}
	}
?>	