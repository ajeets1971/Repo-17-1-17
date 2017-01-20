<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>
	<script src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
	<style type="text/css">
		#delete,#Update_getData,#Insert_Data{
			border-radius: 5px;
			width: 200px;
			height: 40px;
		}
	</style>
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
				var rows = table.rows().data();

	           	for(var i=0;i<length;i++)
	           	{
	           		arr[i]=rows[i];
	           	}
	           	var jsonStr=JSON.stringify(arr);
	           	//console.log(jsonStr);
	           	$.ajax({
		        	type: "POST",
		        	url: "DataTable_Update_Reorder.php",             
		           	data: "action=order&reorder="+jsonStr,
		        	success: function(response){
		        		console.log(response);               
		        	}
				});
	       });
		    $('#Product_info tbody').on( 'click', 'tr', function () {
		        if ( $(this).hasClass('selected') ) {
		            $(this).removeClass('selected');
		        }
		        else {
		            table.$('tr.selected').removeClass('selected');
		            $(this).addClass('selected');
		        }
		    } );
		    $('#delete').click( function () {
		        var dltstr=table.row('.selected').data();
		        var dltjsonStr=JSON.stringify(dltstr);
	           	//console.log(dltjsonStr);
	           	$.ajax({
		        	type: "POST",
		        	url: "DataTable_Update_Reorder.php",             
		           	data: "action=delete&dlt_rec="+dltjsonStr,
		        	success: function(response){
		        		console.log(response);
		        		table.ajax.reload();               
		        	}
				});
		    } );
		    $('#Update_getData').click( function () {
		    	if(table.row('.selected').data()!=null)
		    	{
		    		var upstr=table.row('.selected').data();
			        var upjsonStr=JSON.stringify(upstr);
		           	//console.log(upjsonStr);
		           	$.ajax({
			        	type: "POST",
			        	url: "DataTable_Update_Reorder.php",             
			           	data: "action=Update_getData&up_rec="+upjsonStr,
			        	success: function(response){
			        		var data = jQuery.parseJSON(response);
			        		console.log(data);
			        		jQuery("#upProduct_id").val(data.Product_id);
			        		jQuery("#upProduct_Name").val(data.Product_Name);
			        		jQuery("#upColor").val(data.Color);
			        		jQuery("#upSize").val(data.Size);
			        		jQuery("#upWeight").val(data.Weight);
			        		jQuery("#upManufacturer").val(data.Manufacturer);
			        		jQuery("#upPrice").val(data.Price);
			        		// jQuery(".modal_title").html("Update Employee");
							jQuery("#upModal").modal('show');            
					    }
					});
		    	}
		        else
		        {
		        	console.log("sorry");
		        }
		    } );
		    $("#Insert_Data").click(function(){
		    	table.search('').draw();
		    	jQuery("#InsertModal").modal('show'); 
		    });
		    $("#updatedata").click(function()
		    {
		    	$.ajax({    //create an ajax request to load_page.php
			        type: "POST",
			        url: "DataTable_Update_Reorder.php",             
			        data: new FormData($("#update_form")[0]),
			        processData: false,
					contentType: false,
			        success: function(response){
			        	console.log(response);
			     		table.ajax.reload();             
			        }
				});
		    });
		    $( "#Insert" ).click(function() {
				$.ajax({    //create an ajax request to load_page.php
			        type: "POST",
			        url: "DataTable_Update_Reorder.php",             
			        data: new FormData($("#insert_form")[0]),
			        processData: false,
      				contentType: false,
			        success: function(response){
			        	console.log(response);
			        	$("#insert_form")[0].reset();
			        	table.ajax.reload();                
			        }
				});
			});
		});
	</script>
</head>
<body id="body1">
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
<div>
	<button value="Delete Record" id="delete">Delete Record</button>
	<button value="Update Record" id="Update_getData">Update Record</button>
	<button value="Insert Record" id="Insert_Data">Insert Record</button>
</div>
<div class="modal fade" id="upModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal_title">Edit Product</h4>
        </div>
        <div class="modal-body modal_body">
			<form name="form" id="update_form" method="post" action="">
				<input type="hidden" name="upProduct_id" id="upProduct_id">
				<input type="text" name="upProduct_Name" id="upProduct_Name" placeholder="Product Name" /><br><br>
				<input type="text" name="upColor" id="upColor" placeholder="Color"/><br><br>
				<input type="text" name="upSize" id="upSize" placeholder="Size"/><br><br>
				<input type="text" name="upWeight" id="upWeight" placeholder="Weight" /><br><br>
				<input type="text" name="upManufacturer" id="upManufacturer" placeholder="Manufacturer" /><br><br>
				<input type="text" name="upPrice" id="upPrice" placeholder="Price"/><br><br>
				<input type="hidden" name="action" value="update_data"/>
			</form>
        </div>
        <div class="modal-footer">
        <input type="button" id="updatedata" class="btn btn-default" data-dismiss="modal" value="Update">
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="InsertModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal_title">Insert Product</h4>
        </div>
        <div class="modal-body modal_body">
			<form name="form" id="insert_form" method="post" action="">
				<input type="text" name="InProduct_Name" id="InProduct_Name" placeholder="Product Name" /><br><br>
				<input type="text" name="InColor" id="InColor" placeholder="Color"/><br><br>
				<input type="text" name="InSize" id="InSize" placeholder="Size"/><br><br>
				<input type="text" name="InWeight" id="InWeight" placeholder="Weight" /><br><br>
				<input type="text" name="InManufacturer" id="InManufacturer" placeholder="Manufacturer" /><br><br>
				<input type="text" name="InPrice" id="InPrice" placeholder="Price"/><br><br>
				<input type="hidden" name="action" value="insert_data"/>
			</form>
        </div>
        <div class="modal-footer">
        <input type="button" id="Insert" class="btn btn-default" data-dismiss="modal" value="Insert">
        </div>
      </div>
    </div>
  </div>
</body>
</html>