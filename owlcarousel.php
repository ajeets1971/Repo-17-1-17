<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		#owl-demo .item img{
		    display: block;
		    width: 100%;
		    height: 500px;
		}
	</style>
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.css">
	<script type="text/javascript">
		$(document).ready(function() {
 			owlcreate();
		  	$("#Insert").click(function(){
			    $.ajax({
		        	type: "POST",
		        	url: "owlcarousel_Data_File.php",             
		           	data: new FormData($("#imgform")[0]),
		           	processData: false,
      				contentType: false,
		        	success: function(response){
		        		$("#owl-demo").data('owlCarousel').destroy();
		        		var content = "<div class='item'><img src='http://localhost/partsSearch/Pictures/"+response+"' ></div>";
						$("#owl-demo").append(content); 
    					owlreload();
		        		console.log(response+$("#owl-demo").html());	       
		        	}
				});
		    });
		});

		function owlreload()
		{
			$("#owl-demo").owlCarousel({
			    items : 1,
			    slideSpeed : 1000,
			    nav: true,
			    autoPlay: true,
			    dots: true,
			    loop: true,
			    responsiveRefreshRate : 200, 
		  	});
		}
		function owlcreate()
		{
			$.ajax({
	        	type: "POST",
	        	url: "owlcarousel_Data_File.php",             
	           	data: "action=select",
	        	success: function(response){
	        		var data = jQuery.parseJSON(response);
	        		//console.log(data[0].images);
	        		var content = "";
	        		$.each(data, function( index, value ) {
	        			//console.log(value.images);
					  	content += "<div class='item'><img src='http://localhost/partsSearch/Pictures/"+value.images+"' ></div>";
					});
					var owl = $("#owl-demo");
					owl.append(content); 					
		       		owlreload();              
	        	}
			});
		}
	</script>
</head>
<body>
<div id="owl-demo" class="owl-carousel owl-theme">

</div>
<form id="imgform" method="post" action="">
	<input type="file" id="addItem" name="addItem"><br><br>
	<input type="hidden" name="action" value="insert"/>
	<input type="button" name="Insert" value="Insert" id="Insert" /><br><br>
</form>
</body>
</html>