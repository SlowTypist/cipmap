<?php
require_once(dirname(__DIR__).'/includes/admin.php');
$manageresult = "";
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
		if (isset($_GET["getid"]))
		{
			$admin = new admin();
			$locationinfo = $admin->getLocationName($_GET["getid"]);
			$workinghours = $admin->getWorkingHours($_GET["getid"]);
		}
		else
		{
			$admin = new admin();
			$alllocations = $admin->listAllLocations();
		}
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if (isset($_POST['Submit']))
		{
			$boxes = array();
			foreach ($_POST as $name => $value)
			{
    			array_push($boxes, $name);
			}
			array_shift($boxes);
			array_pop($boxes);

			$admin = new admin();
			$alllocations = $admin->listAllLocations();
			$changeTimesResult = $admin->changeWorkingHours($_POST['id'], $boxes);
			if($changeTimesResult == 1)
			{
				$manageresult = "Working hours successfully changed";
			}
			else 
			{
				$manageresult = "Error";
			}
		}
	}
}
?>