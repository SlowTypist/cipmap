<?php
require_once('includes/user.php');
$verifyresult = "";
$verifyerror = "";
session_start();
if ($_SESSION['loggedin'] == true)
{
	header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{	
	if (isset($_GET["id"]))
	{
		$user = new user();
		$result = $user->verifyNewUser($_GET['id'], $_GET['verification_code']);
		if($result > 0)
		{
			$verifyresult = "You have successfully activated your account. Please proceed to the main page to login";
		}
		else if($result == -1) 
		{
			$verifyerror = "Something went wrong (Account already activated?)";
		}
		else if($result == 0) //noch nicht freigeschaltet
		{
			$verifyerror =  "No database connection";
		}
	}
}
else
{
	header('Location: index.php');
}
if($verifyresult !== "")
	$verifyresult = "<p class='result'>{$verifyresult}</p>";
if($verifyerror !== "")
	$verifyerror = "<p class='error'>{$verifyerror}</p>";
?>