<?php 
	require 'class.gallery.php';
	$Gallery = new Gallery; # Instantiate an Object using our class
	session_start(); #start the session so we have access to it throughout the program
	if ($_SESSION["login"] == false) { # check to see if the user is logged out, if so redirect to login page
		header("location: index.php");
		echo "got here!";
	}

	if (isset($_POST["ID"])) {
		if ($_POST["ID"] == "true") { #if the user clicks logout then redirect to login page
			echo "got here!";
			$_SESSION["login"] = false;
			header("location: index.php");
		}
	}
	if (isset($_POST["image"])) { #gets file type
		$fileName = $_POST["image"];
		echo "got here!2222222222";
		$fileArray = explode(".",$fileName);
		$extensionType = "image/".$fileArray[1];
		echo $extensionType;
		if($Gallery->filetypeCheck($extensionType)){
			echo "TRUEEEEEE";
		};
	} 
	
	
 ?>

 <!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form  action="gallery.php" method="post">
		<input type='hidden' name='ID' value="true" />
		<input type="submit" name="logout" value="Logout"> 
	</form>

	<h1>Before image is displayed</h1>

	<form  action="gallery.php" method="post">
		<input type='text' name='caption' placeholder="Caption" />
		<input type='file' name='image' />
		<input type="submit" name="submit" value="Upload File"> 
	</form>
	

	<div>
			<?php
			
			$Gallery->galleryDisplay(); # Call the method through the new Object
		?>
	</div>

		<h1>After image is displayed</h1>

</body>
</html>