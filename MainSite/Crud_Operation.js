function Loaddata()
{
	$.ajax({    //create an ajax request to load_page.php
		type: "POST",
		url: "CRUD_Data_file.php",             
		dataType: "html",
		data: "action=select",   //expect html to be returned                
		success: function(response){                    
			$("#ListData").html(response); 
			//alert(response);
		}
	});
}
$(document).ready(function(){
	$(".delete").click(function()
	{
		var element = $(this);
		var del_id = element.attr("id");
		var info = 'action=delete&employee_id=' + del_id;
		$.ajax({
        	type: "POST",
        	url: "CRUD_Data_file.php",             
           	data: info,
        	success: function(){
        		Loaddata();                
        	}
		});
	});
	$(".update_get_data").click(function()
	{
		var element = $(this);
		var up_id = element.attr("id");
		var info = 'action=fetch_update_data&employee_id=' + up_id;
		$.ajax({
        	type: "POST",
        	url: "CRUD_operation_data_file.php",             
           	data: info,
        	success: function(response){
        		//alert(response);
        		var data = jQuery.parseJSON(response);
        		jQuery("#upemployee_id").val(data.employee_id);
        		jQuery("#upempname").val(data.employee_name);
        		jQuery("#upemail").val(data.email);
        		jQuery("#uphire_date").val(data.hired_date);
        		jQuery("#upsalary").val(data.salary);
        		// jQuery(".modal_title").html("Update Employee");
				jQuery("#myModal").modal('show');
        	}
		});
	});
	$( "#update_data" ).click(function() {               
		var qs= 'action=update&employee_id='+ $('#upemployee_id').val() +'&empname='+ $('#upempname').val() + '&salary=' +$('#upsalary').val() ;
		console.log(qs);
		$.ajax({    //create an ajax request to load_page.php
	        type: "POST",
	        url: "CRUD_operation_data_file.php",             
	        data: qs,
	        success: function(response){ 
	        	console.log(response);
	        	Loaddata();                 
	        }
		});
	});

});

		