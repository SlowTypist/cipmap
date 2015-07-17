<?php
include_once(dirname(__DIR__).'/config/config.php');
include_once dirname(__FILE__).'/db.php';
include_once(dirname(__DIR__).'/libraries/PHPMailer.php');
class appointment
{
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