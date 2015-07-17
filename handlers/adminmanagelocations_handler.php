<?php
require_once(dirname(__DIR__).'/includes/admin.php');
$deleteresult = "";
session_start();
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
if ($_SESSION['loggedin'] == true && $_SESSION['role'] == 3)
{
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{

		if (isset($_GET["getid"]))
		{
			$admin = new admin();
			$locationinfo = $admin->getLocationName($_GET["getid"]);

		}
		else
		{
			$admin = new admin();
			if (isset($_GET["deleteid"]))
			{
				$deleteinfo = $admin->deleteLocation($_GET["deleteid"]);
				if ($deleteinfo == 1)
				{
					$deleteresult = "Location successfully deleted";
				}
				else
				{
					$deleteresult = "Error";
				}

			}
			$admin = new admin();
			$alllocations = $admin->listAllLocations();
		}
				
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if (isset($_POST["Add"]))
		{
			$admin = new admin();
			$addresult = $admin->addLocation($_POST["name"]);
			$alllocations = $admin->listAllLocations();
		}
		if (isset($_POST["Change"]))
		{
			$admin = new admin();
			$addresult = $admin->editLocation($_POST["id"], $_POST["name"]);
			$alllocations = $admin->listAllLocations();
		}
		
	}
	
}
else
{
	header('Location: ../login.php');
}


if($deleteresult !== "")
	$deleteresult = "<p class='error'>{$deleteresult}</p>";

?>