<?php
	session_start();

	require_once 'class.Database.php';

	class Gallery {
		private static $database;

		private static $imageTypes = array(
			'image/jpeg' => "jpeg",
			'image/gif' => "gif",
			'image/png' => "png",
		);

		static function initializeDB() {
			self::initializeDB();
		}

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
				echo '<p>Problem preparing your database query.</p>'
			endif;
		}

		static function logout() {
			unset($_SESSION["login"]);

			header("location: index.php");
		}

		static function filetypeCheck($filetype) {
			if ( array_key_exists($filetype, self::$imageTypes) ):
				return true;
			else:
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
				