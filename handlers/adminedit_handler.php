<?php
require_once(dirname(__DIR__).'/includes/user.php');
require_once(dirname(__DIR__).'/includes/lecture.php');
$changeresult = "";
session_start();
if (isset($_SESSION['LAST_ACTIVITY'])==0 || (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    $_SESSION = array();    // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
}
else
{
		$_SESSION['LAST_ACTIVITY'] = time();
}
if ($_SESSION['loggedin'] == true && $_SESSION['role'] == 3)
{
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		if (isset($_GET["id"]))
		{
			$user = new user();
			$userinfo = $user->getUserInformation($_GET["id"]);

		}
		else
		{
			$user = new user();
			$allusers = $user->listAllUsers();
		}
		
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if (isset($_POST["Change"]))
		{
			if ($_POST['role'] >- 1 && $_POST['role'] < 5 && !empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['matrnr']) && ($_POST['active'] == 1 || $_POST['active'] == 0 ))
			{
				$user = new user();
				$changeinfo = $user->changeUserInformation($_POST['id'], $_POST['email'], $_POST['name'], $_POST['surname'], $_POST['matrnr'], $_POST['active'], $_POST['role']);
				if ($changeinfo == 1)
				{
					$changeresult = "User information was successfully changed";
				}
				else 
				{
					$changeresult = "Database issues";
				}
			}
			else 
			{
				$changeresult = "Incorrent information";
			}
		}

	}
	
}
else
{
	header('Location: ../login.php');
}


if($changeresult !== "")
	$changeresult = "<p class='error'>{$changeresult}</p>";

?>