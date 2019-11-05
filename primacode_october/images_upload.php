<?php
//$conn = mysqli_connect("localhost","prefects_rah", "rahrahrasputin1A!");

$conn = mysqli_connect("localhost", "root", "");

$menuitem_id = $_GET['menuitem_id'];
$name = $_GET['name'];



if(!$conn) {
	$error = 'Unable to connect to the database server.';
	include 'error.php';
	exit();
}

if(!mysqli_set_charset($conn, 'utf8')) {
	$error = 'Unable to set database connection encoding.';
	include 'error.php';
	exit();
}

if(!mysqli_select_db($conn,"prefects_primafood")) {
	$error = 'Unable to locate the database.';
	include 'error.php';
	exit();
}

//pfb blw
if (isset($_POST['action']) and $_POST['action'] == 'upload') {
	if ($_FILES['upload']['name'] == "") {
		echo "<!doctype HTML><html><head><script>alert('Error: no file selected');history.back();</script></head></body></html>";
		$error = 'There was no file selected!';
		include 'error.php';
		exit();
	}
}
//pfb abuv

if (isset($_POST['action']) and $_POST['action'] == 'upload')
{
	// Bail out if the file isn't really an upload
	if (!is_uploaded_file($_FILES['upload']['tmp_name']))
	{
		$error = 'There was no file uploaded!';
		include 'error.php';
		exit();
	}
	
	$uploadfile = $_FILES['upload']['tmp_name'];
	$uploadname = $_FILES['upload']['name'];
	$uploadtype = $_FILES['upload']['type'];
	//$uploaddesc = $_POST['desc'];
	$uploaddata = file_get_contents($uploadfile);

	// Prepare user-submitted values for safe database insert
	//$uploadname = mysqli_real_escape_string($link, $uploadname);
	//$uploadtype = mysqli_real_escape_string($link, $uploadtype);
	//$uploaddesc = mysqli_real_escape_string($link, $uploaddesc);
	//$uploaddata = mysqli_real_escape_string($link, $uploaddata);

	//$uploadname = mysql_real_escape_string($uploadname, $conn);
	//$uploadtype = mysql_real_escape_string($uploadtype, $conn);
	//$uploaddesc = mysql_real_escape_string($uploaddesc, $conn);
	//$uploaddata = mysql_real_escape_string($uploaddata, $conn);


	//	--------------------pb blw-----------------
	//print_r($_FILES);
	
	$uploaddir = "";


	$uploadfile = $uploaddir . $_FILES['upload']['name'];   //   images/realname


	//below..............must be a POSTed file, not GET
	move_uploaded_file($_FILES['upload']['tmp_name'], $uploadfile);    //temp name = strange php name, name = real name............arg order: (file, dest)

	//rename($uploadfile, $uploadname);

	//print_r($_FILES);

	//rename($uploadfile, $uploadname);

//echo "<!doctype HTML><html><head><script>alert('at delete from');</script></head></body></html>";
		$error = 'There was no file selected!';

	//$sql = "INSERT INTO images SET 			filename = '$uploadname' 			menuitem_id = '$menuitem_id'";
	

	//-------------------------delete old (existing) file using old (existing) filename----------------------------
	
	$sql3 = "SELECT  filename FROM images WHERE images.menuitem_id = $menuitem_id ";
	
	$result3 = mysqli_query($conn, $sql3);
		
	if(!mysqli_query($conn, $sql3)) { 
		//$error = 'Error obtaining old filename';
		//include 'error.php';
		//exit;
	}
	else {
		while ($data3 = mysqli_fetch_array($result3)) {
			$old_filename = $data3[0];
			//echo $old_filename;
			unlink($old_filename);
		}	
	}
	
 	$sql = " DELETE FROM images WHERE images.menuitem_id = '$menuitem_id' ";

 	if(!mysqli_query($conn, $sql)) { 
		//$error = 'Error deleting data: ' . mysqli_error($conn, $sql);
		//include 'error.php';
		//exit;
	}
	
	$sql = " INSERT INTO images ( filename, menuitem_id )  VALUES ( '$uploadname', ' $menuitem_id' ) ;";
		
	//$sql = " UPDATE images SET filename = '$uploadname' WHERE menuitem_id = '$menuitem_id'";
		
	$result = mysqli_query($conn, $sql);

	if($result==FALSE)
	{
		$error = 'Database error storing file!';
		include 'error.php';
		exit();
	}

}
	//header('Location: .');
	//exit;

	//----------------------pb abuv--------------------

	//--------get the filename-------------------------

	$sql = "SELECT  filename FROM images WHERE images.menuitem_id = $menuitem_id ";


	$result = mysqli_query($conn, $sql);

	//if (!$result) {
		//echo "Unable to execute a query ";
		//echo "Error " . mysql_errno() . " - " . mysql_error();
		//exit;
	//}

	$numrows = mysqli_num_rows($result);
	$numcols = mysqli_num_fields($result);

	include 'images_form.php';

	exit;

	?>
