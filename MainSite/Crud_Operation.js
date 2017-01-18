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
		var info = 'action=delete&Product_id=' + del_id;
		$.ajax({
        	type: "POST",
        	url: "CRUD_Data_file.php",             
           	data: info,
        	success: function(response){
        		console.log(response);
        		Loaddata();                
        	}
		});
	});
	$(".update_get_data").click(function()
	{
		var element = $(this);
		var up_id = element.attr("id");
		var info = 'action=fetch_update_data&Product_id=' + up_id;
		$.ajax({
        	type: "POST",
        	url: "CRUD_Data_File.php",             
           	data: info,
        	success: function(response){
        		var data = jQuery.parseJSON(response);
        		// console.log(data.Image);
        		jQuery("#upProduct_id").val(data.Product_id);
        		jQuery("#upProduct_Name").val(data.Product_Name);
        		jQuery('#pre_Image').val(data.Image);
        		jQuery('#preview').attr('src','http://localhost/MainSite/Uploads/' + data.Image);
        		jQuery("#upColor").val(data.Color);
        		jQuery("#upSize").val(data.Size);
        		jQuery("#upWeight").val(data.Weight);
        		jQuery("#upManufacturer").val(data.Manufacturer);
        		jQuery("#upPrice").val(data.Price);
        		// jQuery(".modal_title").html("Update Employee");
				jQuery("#myModal").modal('show');
        	}
		});
	});
});

		