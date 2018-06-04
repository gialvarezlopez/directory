<?php 
include('/header.php');
?>
<title>Demo : Crop Image and Upload using jQuery and PHP</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="croppie/croppie.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
<link rel="stylesheet" href="croppie/croppie.css">
<link rel="stylesheet" href="style.css">
<script type="text/javascript" src="upload.js"></script>
<?php include('container.php');?>
<div class="container">
	<h2>Crop Image and Upload using jQuery and PHP</h2>	
	<div class="panel panel-default">
	  <div class="panel-body">
	  	<div class="row">
	  		<div class="col-md-4 text-center">
				<div id="upload-image"></div>
	  		</div>
	  		<div class="col-md-4">
				<strong>Select Image:</strong>
				<br/>
				<input type="file" id="images">
				<br/>
				<button class="btn btn-success cropped_image">Upload Image</button>
	  		</div>			
	  		<div class="col-md-4 crop_preview">
				<div id="upload-image-i"></div>
	  		</div>
	  	</div>
	  </div>
	</div>	
	<br>	
	<div style="margin:50px 0px 0px 0px;">
		<a class="btn btn-default read-more" style="background:#3399ff;color:white" href="http://www.coderszine.com/crop-image-and-upload-using-jquery-and-php/">Back to Tutorial</a>		
	</div>
</div>
<?php include('footer.php');?>
