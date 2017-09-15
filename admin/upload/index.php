<!DOCTYPE>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Image upload</title>
<link href='http://fonts.googleapis.com/css?family=Boogaloo' rel='stylesheet' type='text/css'>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript" src="js/multiupload.js"></script>
<script type="text/javascript">
var config = {
	support : "image/jpg,image/png,image/bmp,image/jpeg,image/gif",		// Valid file formats
	form: "demoFiler",					// Form ID
	dragArea: "dragAndDropFiles",		// Upload Area ID
	uploadUrl: "upload.php"				// Server side upload url
}
$(document).ready(function(){
	initMultiUploader(config);
});
</script>
<link href="css/style.css" type="text/css" rel="stylesheet" />
</head>
<body lang="en">
<center><h1 class="title">Multiple Drag and Drop File Upload - Medium Rec Banner</h1></center>
<div id="dragAndDropFiles" class="uploadArea">
	<h1>Drop Artwork Here</h1>
</div>
<form name="demoFiler" id="demoFiler" enctype="multipart/form-data">
<input type="hidden" name="cat_parent_id" id="input_1" value="2" />
<input type="hidden" name="catId"	id="input_2" value="11" />
<input type="hidden" name="state_id" id="input_3" value="2" />
<input type="hidden" name="location_id" id="input_4" value="20" />
<input type="hidden" name="start_date" id="input_5" value="2013-06-01" />
<input type="hidden" name="end_date" id="input_6" value="2013-08-31" />

<input type="file" name="multiUpload" id="multiUpload" multiple />
<input type="submit" name="submitHandler" id="submitHandler" value="Upload" class="buttonUpload" />
</form>
<div class="progressBar">
	<div class="status"></div>
</div>
</body>
</html>