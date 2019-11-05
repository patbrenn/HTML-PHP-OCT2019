<!DOCTYPE html>
<html  lang="en">
	<head>
		<title>List of menu items</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<style type="text/css">
		table, input, textarea, label, p, h4 { font-family: verdana; font-size: small; }
		th { background-color: azure;}
		/*img { min-width: 150px;}*/
		</style>
	</head>

	<body >  
    <div align="center"> 
    
    <h4>Primafood Live Update Facility</h4>
    <p>
    <a href="login.php" >Exit</a>&nbsp;&nbsp;&nbsp;
    <a href="http://vendor_name.primafood.com/menu.php">View menu on Website</a>&nbsp;&nbsp;&nbsp;
    <a href="?add">Add item</a>
    </p>

		<?php 
		
		if ($numrows>0) {
			
			$menuitem_id="";
		
			echo "<p>Here are all the items in the database: (* indicates no image)</p>";
			
			echo "<table border=\"1\" rules=\"rows\"  cellspacing=\"6px\" cellpadding=\"6px\" width=90% align=\"center\">";
			// date,start_time,end_time,name,description,category,menuitem_id
			echo "<tr><th align=left>Category</th><th align=left>Name</th><th align=left>Description</th><th align=left>price</th><th align=left>Action</th><th align=center>Image</th></tr>";
						
			while ($data = mysqli_fetch_array($result)) {
		
			  echo "<tr>";
			  
			  for ($i=0; $i < $numcols; $i++) {
			  	if($i < $numcols-1) echo "<td>" . $data[$i] . "</td>\n";
			  	if($i==1) $name = $data[$i];  
			  	if($i==4) $menuitem_id = $data[$i];
			  }
			  
				echo "<td><form action=\"\" method=\"post\"/>";
				echo "<input type=\"hidden\" name=\"menuitem_id\" value=\"" . $menuitem_id . "\"/>";
				echo "<input style=\"color: blue;\" type=\"submit\" name=\"action\" value=\"edit\"/>";
				echo  "<br/>";
				echo "<input style=\"color: red;\" type=\"submit\" name=\"action\" value=\"delete\" onClick=\" return check_delete();\" />";

		//-------------------		
				$sql2 = "SELECT  filename FROM images WHERE images.menuitem_id = '$menuitem_id' ";

				$result2 = mysqli_query($conn, $sql2);

				//if (!$result2) {
					//echo "Unable to execute a query (2) ";
					//echo "Error " . mysqli_errno() . " - " . mysql_error();
					//exit;
				//}

				$numrows2 = mysqli_num_rows($result2);
				
				while ($data2 = mysqli_fetch_array($result2)) {
					$image_name = $data2[0]; //echo $numrows2;
				}
				
				?>
				
				<input style="color: green;" type="button"  
				
				<?php    
			
				if($numrows2 > 0) {
					echo " value=\"image upload\" ";
				}      
				else echo " value=\"*image upload\" ";
				
				?>
				
				onClick = "window.location.href = 'images_upload.php?menuitem_id=<?php echo $menuitem_id; ?>&name=<?php echo $name; ?>'">				
				
								
				
				<?php
				echo "</form></td>";
				
				
				
				if($numrows2 > 0) {
					echo "<td align=center><a href=\"" . $image_name. "\"><img border=1 height=25% width=25% src=" . $image_name ." /></a></td>";
				}
			  
			  	echo "</tr>\n";
			}
			echo "</table>";
		}
		else {
			echo "<p>No items in database.</p>";
		}

		?> 
		
		<script >

	    	function check_delete() {
		    	//return true;
			    return confirm("You are about to delete an item. Continue?");
		    }
		    
		
			
		</script>
        
           </div> 
	</body>

</html>
