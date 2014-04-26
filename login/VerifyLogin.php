<?php
	if (isset($_POST['submit'])) {
		// If password and username match continue
		if ($_POST['username'] == 'username' && $_POST['password'] == 'password') {
			// If correct login your session
			session_start();
			$_SESSION['logged'] = TRUE;
			$_SESSION['User_ID'] = $_POST['username'];
			// Redirect to the home pages
			header("Location: ../options/");
			exit;
		}
	}
	// If there is an error send you back to login
	header("Location: ./");
	exit;
?>