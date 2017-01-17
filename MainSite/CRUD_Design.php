<style type="text/css">
    #insert_form, #ListData {
        margin-left: 300px;
        margin-top: 50px;
    }
 </style>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<script src="Crud_Operation.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			Loaddata();
	  		$( "#Insert" ).click(function() {

				var qs='action=insert&Product_Name='+ $('#Product_Name').val() +'&Image='+ $('#Image')[0].files + '&Color=' + $('#Color').val() + '&Size=' +$('#Size').val() + '&Weight=' +$('#Weight').val() + '&Manufacturer=' +$('#Manufacturer').val() + '&Price=' +$('#Price').val() ;
				$.ajax({    //create an ajax request to load_page.php
			        type: "POST",
			        url: "CRUD_Data_File.php",             
			        data: new FormData($("#form")[0]),
			        processData: false,
      				contentType: false,
			        success: function(response){
			        	Loaddata();                 
			        }
				});
			});
		});
  	</script>
</head>
<body>

<div id="insert_form">
<h3>Employee Details</h3>
	<form name="form" method="post" action="" id="form">
		<input type="text" name="Product_Name" id="Product_Name" placeholder="Product Name" /><br><br>
		<input type="file" name="Image" id="Image"/><br><br>
		<input type="text" name="Color" id="Color" placeholder="Color"/><br><br>
		<input type="text" name="Size" id="Size" placeholder="Size"/><br><br>
		<input type="text" name="Weight" id="Weight" placeholder="Weight" /><br><br>
		<input type="text" name="Manufacturer" id="Manufacturer" placeholder="Manufacturer" /><br><br>
		<input type="text" name="Price" id="Price" placeholder="Price"/><br><br>
		<input type="hidden" name="action" value="insert"/>
		<input type="button" name="Insert" value="Insert" id="Insert" /><br><br>
	</form>
</div>
<br><hr>
<div id="ListData" align="center"></div>
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal_title">Modal Header</h4>
        </div>
        <div class="modal-body modal_body">
			<form name="form" id="update_form" method="post" action="">
				<input type="hidden" id="upemployee_id" value="">
				<input type="text" name="empname" value="" placeholder="Employee Name" id="upempname"><br><br>
				<input type="text" name="email" value="" readonly=true placeholder="Email" id="upemail"> <br><br>
				<input type="text" name="hire_date" value="" readonly=true id="uphire_date"> <br> <br>
				<input type="text" name="salary" value="" placeholder="Salary" id="upsalary"><br><br>
			</form>
        </div>
        <div class="modal-footer">
        <input type="button" id="update_data" class="btn btn-default" data-dismiss="modal" value="Update">
        </div>
      </div>
    </div>
  </div>
</body>
</html>
<?php

?>

