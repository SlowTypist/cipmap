<?php
require_once('includes/user.php');
$forgotresult = "";
session_start();
if ($_SESSION['loggedin'] == true)
{
	header("Location:index.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	if (isset($_POST["Forgot"]))
	{
		$user = new user();

		$result = $user->sendForgot($_POST['email']);
		if ($result == -1)
		{
			$forgotresult = "This email is not registered in the system";
		}
		if ($result == 1)
		{
			$forgotresult = "Activation link sent. Please check your email";
		}
		if ($result == -3)
		{
			$forgotresult = "Database issues";
		}	
		if ($result == -2)
		{
			$forgotresult = "Your account is not activated yet";
		}	
		if ($result == -4)
		{
			$forgotresult = "SMTP error";
		}	

	}

}
if($forgotresult !== "")
	$forgotresult = "<p class='error'>{$forgotresult}</p>";

?>