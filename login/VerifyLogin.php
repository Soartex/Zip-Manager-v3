<?php
  
  // Data hash arrays
  $users = array(1 => 'username', 2 => 'username2', 3 => 'username3');
  $user_pass = array(1 => 'password', 2 => 'password2', 3 => 'password3');
  $user_id = array(1 => 'Soartex', 2 => 'FYD', 3 => 'JSTR');
  // Set default values if not sent
  $userName = isset($_POST['username']) ? $_POST['username'] : '';
  $password = isset($_POST['password']) ? $_POST['password'] : '';
  
  // See if the user is a user
  if (in_array($userName, $users)) {
    $userID = array_search($userName, $users);
    // See if the user password matches the one sent
    if ($password == $user_pass[$userID]) {
			// If correct login your session
			session_start();
			$_SESSION['logged'] = TRUE;
			$_SESSION['User_ID'] = $user_id[$userID];
			// Redirect to the option page
			header("Location: ../options/");
			exit;
		}
	}
	// If there is an error send you back to login
	header("Location: ./");
	exit;
?>