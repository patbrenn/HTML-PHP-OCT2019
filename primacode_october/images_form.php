<!DOCTYPE html>
<html lang="en">
<head>
<title>Image Upload</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<style type="text/css">
table,input,textarea,label,p,h4 {
	font-family: verdana;
	font-size: small;
}

th {
	background-color: azure;
}

body {
	margin: auto;
	max-width: 950px;
}
</style>

<script type="text/javascript">
   	function check_upload() {
	  	return true;
	    return confirm("Large files may take some time to upload. Continue?");
	}
			
</script>

</head>
<body>
<div align="center">
<h4>Image Upload:&nbsp;<?php echo $name; ?></h4>
<p><a href="cms.php">Back to item list</a></p>

<form action="" method="post" enctype="multipart/form-data">

<div><label for="upload">Upload File: <input type="file" 	id="upload" name="upload" /></label></div>

<!--  <div><label for="desc">File Description: <input type="text" id="desc" name="desc" maxlength="255" /></label></div>-->

<div><input type="submit" value="Upload" onclick="return check_upload();" /></div>
<div><br /><br /></div>
<div><input type="hidden" name="action" value="upload" /></div>

</form>




	<?php 
	if ($numrows > 0) {

		echo "<p>Here is the image for this item. To enlarge the image, click it.</p>";
			
		echo "<table border=\"1\" rules=\"rows\" cellspacing=\"6px\" cellpadding=\"6px\" width=90%>";
		// date,start_time,end_time,description_header,description,venue,event_id
		echo "<tr><th>filename</th><th>Image</th></tr>";

		while ($data = mysqli_fetch_array($result)) {

			echo "<tr>";

			for ($i=0; $i<$numcols; $i++) {
				echo "<td align=\"center\">" . $data[$i] . "</td>\n";

				echo "<td align=\"center\"><a href=\"$data[$i]\"><img border = 1 height=35% width=35% src=" . $data[$i] ." /></a></td>";
			}

			echo "</tr>\n";
		}
		echo "</table><br />";
	}
	else {
		echo "<p>No images in database.</p>";
	}



?>
</div>

</body>
</html>
