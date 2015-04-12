<?php
	require_once 'class.gallery.php';
?><!doctype html>
<html>

	<head>
		<title>Gallery</title>
	</head>

	<body>

		<h1>Before image is displayed</h1>

		<div>
 			<?php
				$Gallery = new Gallery; # Instantiate an Object using our class
				$Gallery->galleryDisplay(); # Call the method through the new Object
			?>
		</div>

		<h1>After image is displayed</h1>

	</body>

</html>
