<?php
require_once('includes/user.php');
$loginerror = "";
session_start();
if ($_SESSION['loggedin'] == true)
{
	$_SESSION['LAST_ACTIVITY'] = time();
	if ($_SESSION['role'] == 0)
	{
		header('Location: student1.php');
	}
	if ($_SESSION['role'] == 1)
	{
		header('Location: tutor1.php');
	}
	if ($_SESSION['role'] == 2)
	{
		header('Location: teacher1.php');
	}
	if ($_SESSION['role'] == 3)
	{
		header('Location: admin/admin.php');
	}

}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (isset($_POST["login"]))
	{
		$user = new user();

		$email = $_POST['email'];
		$pw = $_POST['pw'];
		$result = $user->login($email, $pw);
		if($result["id"] > 0)
		{
			$_SESSION['loggedin'] = true;
			$_SESSION['user'] = $result["id"];
			$_SESSION['role'] = $result["role"];
			$_SESSION['LAST_ACTIVITY'] = time();
			header('Location: index.php');
		}
		else if($result == -1) 
		{
			$loginerror = "Wrong email or password";
		}
		else if($result == -2) //noch nicht freigeschaltet
		{
			$loginerror =  "Account not activated yet. Please confirm your account with a link sent to your email";
		}
		else
		{
			$loginerror =  "System error";
		}
	}

}
if($loginerror !== "")
	$loginerror = "<p class='error'>{$loginerror}</p>";

?>