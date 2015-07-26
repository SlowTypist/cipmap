<?php
require_once('includes/user.php');
require_once('includes/lecture.php');
require_once('includes/homework.php');
require_once('includes/appointment.php');
require_once('includes/location.php');
$deletemessage = "";
$addmessage = "";
session_start();
if (isset($_SESSION['LAST_ACTIVITY'])==0 || (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
    // last request was more than 30 minutes ago
    $_SESSION = array();    // unset $_SESSION variable for the run-time 
    session_destroy();   // destroy session data in storage
    header('Location: login.php');
}
else
{
		$_SESSION['LAST_ACTIVITY'] = time();
}
if ($_SESSION['loggedin'] == true)
{
	if ($_SERVER['REQUEST_METHOD'] == 'GET')
	{
		if (isset($_GET["h"]))
		{
			$appointment = new appointment();
			$homework = new homework();
			$location = new location();
			$appointmentinfo = $appointment->userHomeworkAppointment($_SESSION['user'], $_GET["h"]);
			if ($appointmentinfo == -1)
			{
				$homeworkinfo = $homework->getHomeworkInfoNoSolution($_GET["h"]);
				$homeworklocations = $homework->getHomeworkLocations($_GET["h"]);
				foreach ($homeworklocations as $key => $value)
				{
					$homeworklocations[$key]["freeslots"]=$appointment->countFreeSlotOnLocationBetweenDates($value["location_id"],$homeworkinfo["start"], $homeworkinfo["end"]);
				}
			}
			else
			{
				$teammates_info = $appointment->searchAppointmentByCode($_GET["h"], $appointmentinfo["code"]);
			}
		}
		else
		{	
			header('Location: index.php');
		}
	}
	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		if (isset($_POST["loc"]) && ($appointment->userHomeworkAppointment($_SESSION['user'], $_POST["h"]) != -1) )						///work for different sequential pages, when you choose timeslot
		{
			$appointment = new appointment();
			$homework = new homework();
			$location = new location();
			$homeworkinfo = $homework->getHomeworkInfoNoSolution($_POST["h"]);
			$homeworklocations = $homework->getHomeworkLocations($_POST["h"]);
			if (isset($_POST['day']))
			{
				$workingHoursOnDay = $location->getWorkingHoursOnDay($_POST["loc"], date('N', strtotime($_POST["day"])));
				if (!isset($_POST["confirmed"]))
				{
					$availableTimeslots = array();
					foreach ($workingHoursOnDay as $key => $value) {
						$itertime = $value["open_time"];
						while (strtotime($itertime) < strtotime($workingHoursOnDay[$key]["close_time"]))
						{
							if ($appointment->isTimeslotOpen($_POST["loc"], $_POST["day"], date("H:i:s", strtotime('+20 minutes', strtotime($itertime))) ))
							{
								array_push($availableTimeslots, date("H:i:s", strtotime('+20 minutes', strtotime($itertime))));	
							}
							if ($appointment->isTimeslotOpen($_POST["loc"], $_POST["day"], date("H:i:s", strtotime('+40 minutes', strtotime($itertime))) ))
							{
								array_push($availableTimeslots, date("H:i:s", strtotime('+40 minutes', strtotime($itertime))));	
							}
							$itertime = date ("H:i", strtotime('+60 minutes', strtotime($itertime)));
						}
					}
				}
				else	//multiple checks go further
				{
					foreach ($homeworklocations as $key1 => $value1) {
						if ($value1["location_id"] == $_POST["loc"])							// is location right?
						{
							if ($_POST["day"] >= $homeworkinfo["start"] && $_POST["day"] <= $homeworkinfo["end"])	// is the day between the legal borders?
							{
								foreach ($workingHoursOnDay as $key2 => $value2) {
									if ($_POST["t"] > $value2["open_time"] && $_POST["t"] < $value2["close_time"])	// is time set on working hours?
									{
										if ((date('i', strtotime($_POST["t"])) == "20" || date('i', strtotime($_POST["t"])) == "40")					// is minute set to 20 or 40?
											&& date('s', strtotime($_POST["t"])) == "00" 																//is second set to 00?
											&& $appointment->isTimeslotOpen($_POST["loc"], $_POST["day"], $_POST["t"]))									// is timeslot free>
										{
											$newAppointment_id = $appointment->addAppointment(date ("Y-m-d H:i:s", strtotime($_POST['day']." ".$_POST['t'])),$_SESSION['user'], $_POST["h"], $_POST["loc"]);
											if ($newAppointment_id>0)
											{
												$addmessage="Your appointment is successfully added";
											}
											else 
											{
												$addmessage="Error. Please try again";
											}
										}
									}
								}
							}
						}
					}
				}
			}
			else 	//if dayis not set
			{
				$availableDays = array();
				$dayData = array();
				if ($homeworkinfo["start"] >= date ('Y-m-d', time()))
				{
					$iterday = $homeworkinfo["start"];
				}
				else 
				{
					$iterday = date ('Y-m-d', time());
				}
				while (strtotime($iterday) <= strtotime($homeworkinfo["end"])) 
				{
					if(date ("D", strtotime($iterday)) != "Sat" && date ("D", strtotime($iterday)) != "Sun" )
					{
						$dayData["day"] = date ("Y-m-d", strtotime($iterday));
						$dayData["slots"] = $appointment->countFreeSlotOnLocationBetweenDates($_POST["loc"],date ("Y-m-d", strtotime($iterday)), date ("Y-m-d", strtotime($iterday)));
						array_push($availableDays, $dayData);
 					}
 					$iterday = date ("Y-m-d", strtotime("+1 day", strtotime($iterday)));
 				}
			}
		}
		else if (isset($_POST["codeGiven"]))
		{
			$codeGivenError = "";
			$_POST['code'] = trim($_POST['code']);
			$appointment = new appointment();
			$homework = new homework();
			$location = new location();
			$homeworkinfo = $homework->getHomeworkInfoNoSolution($_POST["h"]);
			$homeworklocations = $homework->getHomeworkLocations($_POST["h"]);
			$app_info = $appointment->searchAppointmentByCode($_POST["h"], $_POST["code"]);
			if ($appointment->userHomeworkAppointment($_SESSION['user'], $_POST["h"]) == -1)
			{
				if (count($app_info) < $homeworkinfo['max_group_size'])
				{
					if (strtotime($app_info[0]["time"]) > time())
					{
						$sameUserTestPassed = 1;
						foreach ($app_info as $key => $value) {
							if($value['user_id'] == $_SESSION['user'])
							{
								$sameUserTestPassed = 0;
								$codeGivenError = "You cannot add yourself to the same appointment (What are you doing here anyway?)";
							}
						}
					}
					else
					{
						$codeGivenError = "Sorry, but this appointment already took place";
					}
				}
				else
				{
					$codeGivenError = "Sorry, group is full";
				}
			}
			else
			{
				$codeGivenError = "You already have an appointment.";
			}
		}
		else if (isset($_POST["codeConfirmed"]))
		{
			$codeConfirmed = "";
			$appointment = new appointment();
			$homework = new homework();
			$location = new location();
			$homeworkinfo = $homework->getHomeworkInfoNoSolution($_POST["h"]);
			$homeworklocations = $homework->getHomeworkLocations($_POST["h"]);
			$app_info = $appointment->searchAppointmentByCode($_POST["h"], $_POST["code"]);
			if ($appointment->userHomeworkAppointment($_SESSION['user'], $_POST["h"]) == -1)
			{
				if (count($app_info) < $homeworkinfo['max_group_size'])
				{
					if (strtotime($app_info[0]["time"]) > time())
					{
						$sameUserTestPassed = 1;	
						foreach ($app_info as $key => $value) {
							if($value['user_id'] == $_SESSION['user'])
							{
								$sameUserTestPassed = 0;
								$codeConfirmed = "You are already set for an appointment with this code";
							}
						}
						if ($sameUserTestPassed)
						{
							$newAppointment_id = $appointment->addAppointment($app_info[0]['time'],$_SESSION['user'], $_POST["h"], $app_info[0]["location_id"], $app_info[0]["code"]);
							if ($newAppointment_id>0)
							{
								$codeConfirmed="Your appointment is successfully added";
							}
							else 
							{
								$codeConfirmed="Error. Please try again";
							}					
						}
					}
					else
					{
						$codeConfirmed = "Sorry, but this appointment already took place";
					}
				}
				else
				{
					$codeConfirmed = "Sorry, group is full";
				}
			}
			else
			{
				$codeConfirmed = "You already have an appointment.";
			}
		}
		else if (isset($_POST["deleteAppointment"]))
		{
			$appointment = new appointment();
			$appointmentinfo = $appointment->userHomeworkAppointment($_SESSION['user'], $_POST["homework_id"]);
			if ($appointmentinfo != -1)
			{
				$appointmentday = date("Y-m-d", strtotime($appointmentinfo["time"]));
				$currentday = date("Y-m-d" ,time());
				if ($appointmentday > $currentday)
				{
					$cancelAppointment = $appointment->deleteAppointment($appointmentinfo["appointment_id"]);
					if ($cancelAppointment)
					{
						$deletemessage = "You have successfully canceled your appointment";
					}
					else
					{
						$deletemessage = "Error";
					}
				}
				else
				{
				 	$deletemessage = "You cannot cancel this appointment";
				}
			} 
		}
	}
}
?>