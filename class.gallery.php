<?php
	session_start();

	class Gallery {

		private static $database;

		public function initializeDB() {
			# New mysqli Object for database communication
			self::$database = new mysqli("localhost", "tardissh_kles", "8608!", "tardissh_lestarge");

			# Kill the page is there was a problem with the database connection
			if ( self::$database->connect_error ):
				die( "Connection Error! Error: " . $this->database->connect_error );
			endif;
		}

		private static $imageTypes = array(
			'image/jpeg' => "jpeg",
			'image/gif' => "gif",
			'image/png' => "png",
		);

		// static function initializeDB() {
		// 	self::initializeDB();
		// }

		static function login($user,$password) {
			self::initializeDB();
		
			$query = "
				SELECT
					user,
					password
				FROM
					gallery_users
				WHERE
					user=? AND password=?
			";

			if ( $loginStatus = self::$database->prepare($quer) ):
				$loginStatus->bind_param(
					'ss',
					$user,$password
				);

				$loginStatus->execute();

				$loginStatus->store_results();

				if ( $loginStatus->num_rows == 1 ):
					$_SESSION["login"] = true;

					header("location: gallery.php");

					$loginStatus->close();
				else:

					$_SESSION["login"] = false;

					header("location: index.php?error");

					$loginStatus->close();
				endif;
			else:
				echo '<p>Problem preparing your database query.</p>';
			endif;
		}

		static function logout() {
			unset($_SESSION["login"]);

			header("location: index.php");
		}

		static function filetypeCheck($filetype) {
			echo "got here!33333333";
			echo $filetype;
			if ( array_key_exists($filetype, self::$imageTypes) ):
				echo "got here!44444444";
				return true;
			else:
				echo "got here!55555555";
				return false;
			endif;
		}

		static function newGalleryImage($image,$caption) {
			self::initializeDB();

			$insert_query = "
				INSERT INTO
					gallery_images
					(caption, extension)
				VALUES
					(?,?)
			";

			$file_ext = self::$imageTypes[$image['type']];

			if ( $newImage = self::$database->prepare($insert_query) ):
				$newImage->bind_param(
					'ss',
					$caption, $file_ext
				);

				$newImage->execute();

				$imageID = self::$database->insert_id;

				$filename = $imageID.".".$file_ext;
				
				copy($image['tmp_name'],"gallery_images/".$filename);

				//Get the Name Suffic on basis of the mime type
				$function_suffix = strtoupper($file_ext);
				//Build Function name for ImageCreateFromSUFFIX
				$function_to_read = 'ImageCreateFrom' . $function_suffix;
				//Build Function name for ImageSUFFIX
				$function_to_write = 'Image' . $function_suffix;

				//Get uploaded image dimensions
				$size = GetImageSize("gallery_images" . $filename);
					if($size[0] > $size[1]):
						//Thumbnail size formula for wide images
						$thumbnail_width = 200;
						$thumbnail_height = (int)(200 * $size[1] / $size[0]);
					else:
						//Thumbnail size formula for wide images
						$thumbnail_width = (int)(200 * $size[0] / $size[1]);
						$thumbnail_height = 200;
					endif;

				$source_handle = $function_to_read("gallery_images/" .$filename);
				if ($source_handle):
					//Let's create a blank image for the thumbnail
					$destination_handle = 
						ImageCreateTrueColor($thumbnail_width, $thumbnail_height);

					//Now we resize it 
					ImageCopyResampled($destination_handle, $source_handle,
						0, 0, 0, 0, $thumbnail_width, $thumbnail_height, $size[0], $size[1]);
				endif;

				// Let's save the thumbnail
				$function_to_write($destination_handle, "gallery_images/tb_" . $filename);

				header("location: gallery.php");

				$newImage->close();
				endif;
			}

			static function galleryDisplay() {
				self::initializeDB();

				$query = "
					SELECT
						id, caption, extension
					FROM
						gallery_images
					ORDER BY
						id ASC
				";

				if ( $galleryImages = self::$database->prepare($query) ):
					$galleryImages->execute();
					$galleryImages->store_result();
					$galleryImages->bind_result($id,$caption,$extension);

						if ( $galleryImages->num_rows == 0 ):
							echo "<p class='error'>No images currently in the gallery.</p>";
						else:
							while( $galleryImages->fetch()):
								echo "
									<a href='fullimage.php?id=$id&extension=$extension'>
										<figure>
											<img src='gallery_images/tb_$id.$extension' alt='$caption' />
											<figcaption>$caption</figcaption>
										<figure>
									</a>
								";
							endwhile;
						endif;
					endif;
				}
	}
?>