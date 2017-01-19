<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		    var table = $('#Product_info').DataTable( {
		    	"bFilter": false,
				"bLengthChange": false,
				"bSort": true,
				"bProcessing": false,
				"bServerSide": false,
				"info": false,
				"scrollY" : '200px',
				"serverSide": true,
				"ordering": true,
				"searching": true,
				"rowReorder": {
		             "update": true,
		             //"dataSrc": '.ord-id'
		         },
		         "dom": 'Bfrtip',
		        "sAjaxSource": "DataTable_Data_File.php",
		        "oLanguage": {
					"sEmptyTable": "No Review founds in the system.",
					"sZeroRecords": "No Connected account to display",
					"sProcessing": "Loading..."
				},
				"fnPreDrawCallback": function (oSettings) {
										//logged_in_or_not();
										
				},
				"fnServerParams": function (aoData) {
					aoData.push({"name": "getProduct", "value": true});
				}	
		    });
		    var arr=new Array();
			$('#Product_info').on('draw.dt', function () {
				var length = $('#Product_info tr').length-1;
	           	for(var i=0;i<=length;i++)
	           	{
	           		arr[i]=table.row(i).data();
	           	}
	           	console.log(arr);
	       });
		});
	</script>
</head>
<body>
<table border=1 id="Product_info">
	<thead>
		<tr>
			<td>Sequence No.</td>
			<td>Product Name</td>
			<td>Color</td>
			<td>Size</td>
			<td>Weight</td>
			<td>Manufacturer</td>
			<td>Price</td>
		</tr>
	</thead>
</table>
</body>
</html>