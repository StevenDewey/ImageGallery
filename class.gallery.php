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

			static

		}
	}
 ?>