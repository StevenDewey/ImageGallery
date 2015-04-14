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

	if (isset($_POST["Delete"])) {
		echo "DELETING";
		$Gallery->removeImage($_POST["ID"], $_POST["fileName"]);
		header("location: gallery.php");
	}
	
	if (isset($_FILES["image"])) { #gets file type
		$target_dir = "gallery_images/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		echo $imageFileType . "<br>";
		#$something = $_FILES["image"]["tmp_name"];
		#echo $something . "<br>";
		#echo "got here!2222222222<br>";
		$fileName = $_FILES["image"]["name"];
		echo "got here!2222222222<br>";
		#$fileArray = explode(".",$fileName);
		#$extension = $fileArray[1];
		$extensionType = "image/".$imageFileType;
		echo $extensionType . "<br>";
		if($extensionType == "image/jpg" or "image/JPG"){
			$extensionType = "image/jpeg";
		}
		if($Gallery->filetypeCheck($extensionType)){
			echo "TRUEEEEEE";
			$Gallery->newGalleryImage($_FILES["image"], $_POST["caption"]);
		}
		else{
			echo "<h1>YOU SHALL NOT PAAAAASSSS!!!!!!!!!</h1>";
		}
	} 
	
	
 ?>

 <!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<form  action="gallery.php" method="post">
		<input type='hidden' name='ID' value="true" />
		<input type="submit" name="logout" value="Logout"> 
	</form>

	<h1>Before image is displayed</h1>

	<form  action="gallery.php" method="post" enctype="multipart/form-data">
		<input type='text' name='caption' placeholder="Caption">
		<input type='file' name="image" id="image">
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