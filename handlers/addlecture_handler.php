<?php
require_once(dirname(__DIR__).'/includes/lecture.php');
$result = "";
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
if ($_SESSION['loggedin'] == true && ($_SESSION['role'] == 3 || $_SESSION['role'] == 2))
{
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if (isset($_POST["Add"]))
		{
			$lecture= new lecture();
			$addresult = $lecture->addLecture($_POST["name"], $_POST["teacher"], $_POST["max_group_size"]);
			if ($addresult > 0)
			{
				$result = "Lecture successfully added";

			}
			else
			{
				$result = "Error";
			}
		}
		
	}
	
}
else
{
	header('Location: ../login.php');
}
if($result !== "")
	$result = "<p class='error'>{$result}</p>";

?>