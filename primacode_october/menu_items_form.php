<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $pagetitle; ?></title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<style type="text/css">
input,textarea,label,p,h4 {
	font-family: verdana;
	font-size: small;
}

label {
	color: green;
}
</style>

</head>
<body>
<div align="center">

<h4>Primafood - YOU ARE ADDING OR EDITING A MENU ITEM</h4>
<p><a href="cms.php">Start over</a></p>
<form action="?<?php echo $action; ?>" method="post">
<label>Category:

<input type="radio" name="category" size="10" value="Starter" <?php if($category == "Starter") echo "checked = true"?>>Starter


<input type="radio" name="category" size="10" value="Main" 	<?php if($category == "Main") echo "checked = true"?>>Main

<input type="radio" name="category" size="10" value="Dessert" 	<?php if($category == "Dessert") echo "checked = true"?>>Dessert

<input type="radio" name="category" size="10" value="Beverage" 	<?php if($category == "Beverage") echo "checked = true"?>>Beverage

</label>

<br />
<br />


<label>Name: <input type="text" size="80" name="name" value="<?php echo $name;  ?>"></label><br />
<br />


<label>Description:<br />
<textarea name="description" rows="10" cols="80"><?php echo $description; ?></textarea></label><br />
<br />


<label>Price:<input type="text" name="price" size="20" value="<?php  echo $price; ?>"></label><br />
<br />

<input type="hidden" name="menuitem_id" size="80" 	value="<?php echo $menuitem_id; ?>">

<input type="submit" id="my_submit">

</form>

</div>

</body>
</html>
