<?php
require_once('includes/user.php');
$pwchangeresult = "";
session_start();
if ($_SESSION['loggedin'] != true)
{
	
	header('Location: index.php');
}
if (isset($_SESSION['LAST_ACTIVITY'])==0 || (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    $_SESSION = array();    // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    header('Location: ../login.php');
}
else
{
		$_SESSION['LAST_ACTIVITY'] = time();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (isset($_POST["Changepw"]))
	{
		$user = new user();

		$result = $user->changePassword($_SESSION['user'], $_POST['current_pw'], $_POST['new_pw'], $_POST['new_pw_repeat']);
		if ($result > 0)
		{
			$pwchangeresult = "Password successfully changed. Please login again with your new password.";
			$_SESSION = array();
			session_destroy();
		}
		if ($result == -1)
		{
			$pwchangeresult = "Your current password doesn't match. Please try again";
		}
		if ($result == -2)
		{
			$pwchangeresult = "Your passwords don't match. Please try again";
		}
		if ($result == -3)
		{
			$pwchangeresult = "Your didn't enter your new password. Please try again";
		}
		if ($result == -4)
		{
			$pwchangeresult = "Your new password must be at least 6 symbols long. Please try again";
		}		
	}

}
if($pwchangeresult !== "")
	$pwchangeresult = "<p class='error'>{$pwchangeresult}</p>";

?>