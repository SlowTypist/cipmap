<?php
include_once(dirname(__DIR__).'/config/config.php');
include_once dirname(__FILE__).'/db.php';
include_once(dirname(__DIR__).'/libraries/PHPMailer.php');
class appointment
{
	public function isTimeslotOpen($location_id, $day, $time)
	{
		$db = db_connect();
		if ($db)
		{
			try
			{
				$timestamp = $day." ".$time;
				$stmt = $db->prepare("SELECT COUNT(DISTINCT time, location_id) AS taken
										FROM cip_appointment 
										WHERE location_id = :location_id 
										AND time = :time");
				$stmt->bindValue(':time', $timestamp, PDO::PARAM_STR);
				$stmt->bindValue(':location_id', $location_id, PDO::PARAM_INT);
				$stmt->execute();
				$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
				if ($res[0]["taken"] == 0)
				{
					return 1;
				}
				else
				{
					return 0;
				}
			}
			catch (PDOException $e)
			{
				$db = null;
				return 0;
			}

		}
		else 
		{
			return 0;
		}
	}
	public function countFreeSlotOnLocationBetweenDates($location_id, $start, $end)
	{
		$db = db_connect();
		if ($db)
		{
			try
			{
				$freeSlots = 0;										//first we count all available slots, then we count slots already taken and subtract
				if ($start >= date ('Y-m-d', time()))				//if we count before start, then we count for all days, else we count starting from today
				{
					$iterday = $start;
				}
				else 
				{
					$iterday = date ('Y-m-d', time());
				}
				$stmt = $db->prepare("SELECT open_time, close_time FROM cip_working_hours WHERE location_id = :location_id AND day = :day");
				$stmt->bindParam(':location_id', $location_id);
				while (strtotime($iterday) <= strtotime($end)) //count all hours on each day and add them together
				{
					if(date ("N", strtotime($iterday)) != "6" && date ("N", strtotime($iterday)) != "7" )
					{

						$stmt->bindValue(':day', date ('N', strtotime($iterday)), PDO::PARAM_STR);
						$stmt->execute();
						$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						foreach ($result as $key => $value) 
						{
							$freeSlots += ($result[$key]["close_time"]-$result[$key]["open_time"]);
						}
 					}
 					$iterday = date ("Y-m-d", strtotime("+1 day", strtotime($iterday)));
 				}
 				$freeSlots *= 2;						// on each hour there are 2 slots
 				$start = date ("Y-m-d H:i:s", strtotime($start));												//reformat our parameters so that they could be compared with timestamps
 				$end = date ("Y-m-d H:i:s", strtotime("+23 hours 59 minutes 59 seconds", strtotime($end)));
 				$stmt = $db->prepare("SELECT COUNT( DISTINCT time, location_id ) AS takenslots
										FROM cip_appointment
										WHERE location_id = :location_id
										AND time >= :start
										AND time <= :end");
 				$stmt->bindValue(':location_id', $location_id, PDO::PARAM_INT);
 				$stmt->bindValue(':start', $start, PDO::PARAM_STR);
 				$stmt->bindValue(':end', $end, PDO::PARAM_STR);
 				$stmt->execute();
 				$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
 				$freeSlots -= $res[0]["takenslots"];						// freeslots = all slots minus those already taken
				return $freeSlots;
			}
			catch (PDOException $e)
			{
				$db = null;
				return 0;
			}

		}
		else 
		{
			return 0;
		}
	}
	public function allUserLectureAppointments($user_id, $lecture_id)
	{
		$db = db_connect();
		if ($db)
		{

			try
			{
				$stmt = $db->prepare("SELECT A.id, A.time, A.homework_id, C.name AS location_name, A.points 
										FROM cip_appointment A, cip_homework B, cip_location C 
										WHERE A.user_id =:user_id 
										AND B.lecture_id = :lecture_id 
										AND A.homework_id = B.id 
										AND C.id = A.location_id");
				$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
				$stmt->bindValue(':lecture_id', $lecture_id, PDO::PARAM_INT);
				$stmt->execute();
				$userlectureappointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
				return $userlectureappointments;
			}

			catch (PDOException $e)
			{
				$db = null;
				return 0;		//db error
			}
		}
		else
		{
			return 0;		//db error
		}

	}
	public function userHomeworkAppointment($user_id, $homework_id)
	{
		$db = db_connect();
		if ($db)
		{

			try
			{
				$stmt = $db->prepare("SELECT A.id AS appointment_id, A.time, A.location_id, A.points, B.name AS homework_name, B.start, B.end, B.max_points, C.id AS lecture_id, C.name AS lecture_name, C.teacher, C.max_group_size, D.name AS location_name
										FROM cip_appointment A, cip_homework B, cip_lecture C, cip_location D
										WHERE A.user_id=:user_id 
										AND B.id=:homework_id
										AND A.homework_id=B.id
										AND B.lecture_id=C.id
										AND D.id = A.location_id");
				$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
				$stmt->bindValue(':homework_id', $homework_id, PDO::PARAM_INT);
				$stmt->execute();
				$userhomeworkappointment = $stmt->fetch(PDO::FETCH_ASSOC);
				if (!empty($userhomeworkappointment))
				{
					return $userhomeworkappointment;
				}
				else 
				{
					return -1;
				}
			}

			catch (PDOException $e)
			{
				$db = null;
				return 0;		//db error
			}
		}
		else
		{
			return 0;		//db error
		}
	}
	public function addAppointment($time, $user_id, $homework_id, $location_id)
	{
		$db = db_connect();
		if ($db)
		{

			try
			{
				$stmt = $db->prepare("INSERT INTO cip_appointment(time, user_id, homework_id, location_id) VALUES (:time, :user_id, :homework_id, :location_id)");
				$stmt->bindValue(':time', $time, PDO::PARAM_STR);
				$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
				$stmt->bindValue(':homework_id', $homework_id, PDO::PARAM_INT);
				$stmt->bindValue(':location_id', $location_id, PDO::PARAM_INT);
				$stmt->execute();
				$appointment_id =$db->lastInsertId();
				if ($stmt)
				{
					return $appointment_id;
				}
				else
				{
					return 0;
				}
			}

			catch (PDOException $e)
			{
				$db = null;
				return 0;		//db error
			}
		}
		else
		{
			return 0;		//db error
		}

	}
	public function deleteAppointment($appointment_id)
	{
		$db = db_connect();
		if ($db)
		{

			try
			{
				$stmt = $db->prepare("DELETE FROM cip_appointment WHERE id = :appointment_id");
				$stmt->bindValue(':appointment_id', $appointment_id, PDO::PARAM_INT);
				$stmt->execute();
				if ($stmt)
				{
					return 1;
				}
				else 
				{
					return 0;
				}
			}

			catch (PDOException $e)
			{
				$db = null;
				return 0;		//db error
			}
		}
		else
		{
			return 0;		//db error
		}

	}

}

?>