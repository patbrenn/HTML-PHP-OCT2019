
<?php


//usually include form.php here BUT see below for reason why section has moved --

//connect to database -----------------------------------------------------------
//$conn = mysqli_connect("localhost","prefects_rah", "rahrahrasputin1A!");
$conn = mysqli_connect("localhost", "root", "");
//$conn = mysql_connect("localhost", "agape", "");
//$conn = mysql_connect("localhost", "agape", "passwordmnbvcxz");
	
if(!$conn) {
	$error = 'Unable to connect to the database server.';
	include 'error.php';
	exit();
}

if(!mysqli_set_charset($conn,'utf8')) {
	$error = 'Unable to set database connection encoding.';
	include 'error.php';
	exit();
}

if(!mysqli_select_db($conn,"prefects_primafood")) {

//if(!mysql_select_db("agapeencounter_org_calendar_of_events")) {
	$error = 'Unable to locate the database.';
	include 'error.php';
	exit();
}	

//--- usually, the next section goes on top, but -----------------------------------------------------------------

//--- because the form needs data from the database, cannot ------------------------------------------------------

if(isset($_GET["add"])) {

	$pagetitle 	= "New Event";
	$action 	= "addevent";
	//$name		= "name goes here";
	//$date		= "";
	
	//$price 		= "price goes here";
	$description = "";
	$name = "";
	//$start_time = "";
	//$end_time = "";
	$category = "";

	$price="";
	
	$menuitem_id = "event_id will be assigned automatically";
	$button 	= "Add event";

	include 'menu_items_form.php';
	exit;
}

//-----------------------------------------------------------------------------------

//------------------- edit -----------------------------------------------------------

if(isset($_GET['editform'])) {

	//$date = $_POST["date"];
	
	$price = $_POST["price"];
	
	$description = $_POST["description"];
	
	$name = $_POST["name"];
	
	//$start_time = $_POST["start_time"];
	
	//$end_time = $_POST["end_time"];
	
	$category = $_POST["category"];
	
	$menuitem_id = $_POST["menuitem_id"];
	
	//$trainer_id = $_POST["trainer_id"];
	
	if($name == "" || $description == "" || $category == "" || $price == "") { 
		$error = 'Error: missing a required value. GO BACK.';
		include 'error.php';
		exit;
	}
	
//	if(!is_numeric($menuitem_id)) {
//		$error = 'Error: integer value required for menuitem_id.';
//		include 'error.php';
//		exit;
//	}	
	
	//date, start_time, end_time, name, description 
	
 	$sql = " UPDATE menuitems SET
	description = '$description', name = '$name', price  = '$price', category = '$category' WHERE menuitem_id = '$menuitem_id'";
	 echo $sql;
	
 	if(!mysqli_query( $conn, $sql)) { 
		$error = 'Error updating data: ' . mysql_error();
		include 'error.php';
		exit;
	}
	
	header('Location: cms.php');
	exit(); 	
}

//------------------ INSERT ---------------------------------------------------------

if(isset($_POST["name"])) {
	
	$name=$_POST["name"];
	
	$price=$_POST["price"];

//	$date=$_POST["date"];
	
	$description=$_POST["description"];
	
	//	$name=$_POST["name"];
	
	//$start_time=$_POST["start_time"];
	
	//$end_time=$_POST["end_time"];
	
	$category=$_POST["category"];
	
	//$menuitem_id=$_POST["id"];
	
	if($price=="" || $description=="" || $name=="" || $category=="" ) { 
		$error = 'Error: missing a required value. PRESS BACK.';
		include 'error.php';
		exit;
	}
	
//	if(strlen($start_time)!=5 || strlen($end_time)!=5) {
	//	$error = 'Error: times should be in hh:mm format. PRESS BACK.';
		//include 'error.php';
		//exit;
		
		
		
	//}
	
//	if(strlen($date)!=10 || substr($date,4,1)!="-" || substr($date,7,1)!="-" ) {
	//	$error = 'Error: date should be in YYYY-MM-DD format. PRESS BACK.';
		//include 'error.php';
		//exit;
	//}	
	
 	$sql = " INSERT INTO menuitems ( name, description, price, category )  VALUES (  '$name', '$description', '$price', '$category' ) "; 
//start_time, end_time								//'$start_time', '$end_time',
 	if(!mysqli_query( $conn, $sql)) { 
		$error = 'Error inserting data: ' . mysql_error();
		include 'error.php';
		exit;
	}
	
	header('Location: cms.php');
	exit; 	
}

//---------- del course ---------------------------------------------------------------------------------------

if( isset($_POST["action"]) && $_POST["action"] == "delete" ) {
	
	
	$menuitem_id = $_POST["menuitem_id"];
	
 	$sql = " DELETE FROM menuitems  WHERE menuitem_id='$menuitem_id' ";

 	if(!mysqli_query($conn, $sql)) { 
		$error = 'Error deleting data: ' . mysql_error();
		include 'error.php';
		exit;
	}
	
	header('Location: cms.php');
	exit; 	
}


//--------- edit a course ------------------------------------------------------------------------------------

if( isset($_POST["action"]) && $_POST["action"] == "edit" ) {
	
	
	$menuitem_id = $_POST["menuitem_id"];
	
 	$sql = " SELECT category, name, description, price, menuitem_id FROM menuitems WHERE menuitem_id = '$menuitem_id' ";
 	
	$result = mysqli_query($conn, $sql);
	
	if($result==FALSE) {
		$error = 'Error obtaining data to edit: ' . mysql_error();
		include 'error.php';
		exit;
	}	

	$data = mysqli_fetch_array($result);
	
	//$date		= 			$data[0];
	$price = 			$data[3];
	//$end_time 	= 			$data[2];
	$name = 	$data[1];
	$description = 			$data[2];
	
	$category = $data[0];
	
	
	$pagetitle 	= "Edit menu item";
	$action 	= "editform";
	$button 	= "Add menu item";
	
	include 'menu_items_form.php';	
	exit; 	
}


//---------- get courses--------------------------------------------------------------------------------------

//	$sql= "SELECT DATE_FORMAT(date,'%W the %D of %M, %Y'),DATE_FORMAT(start_time,'%h:%i %p'),
	//DATE_FORMAT(end_time,'%h:%i %p'),name,description,category,menuitem_id
		//	 FROM menuitems
			// ORDER BY date DESC";
	
	
	$sql= "SELECT  category, name, description,  price, menuitem_id FROM menuitems  ORDER BY category DESC, name DESC";
	
			 

	$result = mysqli_query($conn,$sql);
	
	if($result==FALSE) {
		$error = 'Error selecting data: ' . mysqli_error();
		include 'error.php';
		exit;
	}

	$numrows = mysqli_num_rows($result);
	$numcols = mysqli_num_fields($result);
	
	
	

//------- now bring in the HTML page that will display them ---------------------------------------------------	
	
	include 'menu_items.php';

?>











