<?php
include_once(dirname(__DIR__).'/config/config.php');
include_once dirname(__FILE__).'/db.php';
include_once(dirname(__DIR__).'/libraries/PHPMailer.php');

	class tutor
	{
		public function listAllHomeworks($lecture_id)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt = $db->prepare("SELECT id, name, start, end, max_points, (link_task != '') AS task_exists, (link_solution != '') AS solution_exists FROM cip_homework WHERE lecture_id=:lecture_id ORDER BY id");
					$stmt->bindValue(':lecture_id', $lecture_id, PDO::PARAM_INT);
					$stmt->execute();
					$db = null;
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					return $result;
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
		public function searchUserByEmail($email)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt = $db->prepare("SELECT id, email, name, surname, matrikelnr, active, role FROM cip_user WHERE email = :email");
					$stmt->bindValue(':email', trim($email), PDO::PARAM_STR);
					$stmt->execute();
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($result)
					{
						return $result;
						$db = null;
					}
					else
					{
						$db = null;
						return -1; //no such email
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
		public function manualActivate($user_id)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt_verify_user = $db->prepare('UPDATE cip_user SET active = 1, activation_hash = NULL WHERE id = :user_id');
					$stmt_verify_user->bindValue(':user_id', intval(trim($user_id)), PDO::PARAM_INT);
					$stmt_verify_user->execute();
					if ($stmt_verify_user->rowCount()>0)
					{
						return 1;
					}
					else
					{
						return 0;
					}
				}
				catch(PDOException $e)
				{
					
					$db = 0;
					return 0;
				}

			}
			else
			{
				
				$db = 0;
				return 0;
			}

		}
		public function listAppointmentsByHomeworkAndDay($homework_id, $day)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{ 
					$stmt = $db->prepare("SELECT A.id, A.time, A.location_id,A.user_id, A.points, B.name AS location_name, C.name, C.surname, C.matrikelnr
											FROM cip_appointment A, cip_location B, cip_user C
											WHERE A.homework_id=:homework_id
											AND DATE(A.time) = :day
											AND B.id = A.location_id 
											AND A.user_id = C.id
											ORDER BY B.id, A.time");
					$stmt->bindValue(':homework_id', $homework_id, PDO::PARAM_INT);
					$stmt->bindValue(':day', $day, PDO::PARAM_STR);
					$stmt->execute();
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					if ($stmt)
					{
						return $result;
					}
					else 
					{
						return -1;
					}
				}
				catch (PDOException $e)
				{
					$db = null;
					return -1;
				}
			}
			else
			{
				return -1;
			}

		}
		public function getSolutionLink($homework_id)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{ 
					$stmt = $db->prepare("SELECT link_solution FROM cip_homework WHERE id=:homework_id");
					$stmt->bindValue(':homework_id', $homework_id, PDO::PARAM_INT);
					$stmt->execute();
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($stmt)
					{
						if (isset($result))
						{
							return $result;
						}
						else 
						{
							return 0;
						}

					}
					else 
					{
						return -1;
					}
				}
				catch (PDOException $e)
				{
					$db = null;
					return -1;
				}
			}
			else
			{
				return -1;
			}
		}
		public function setPoints($id, $points)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt = $db->prepare('UPDATE cip_appointment SET points = :points WHERE id = :id');
					$stmt->bindValue(':id', $id, PDO::PARAM_INT);
					$stmt->bindValue(':points', $points, PDO::PARAM_INT);
					$stmt->execute();
					if ($stmt->rowCount()>0)
					{
						return 1;
					}
					else
					{
						return 0;
					}
				}
				catch(PDOException $e)
				{
					
					$db = 0;
					return 0;
				}

			}
			else
			{
				
				$db = 0;
				return 0;
			}

		}
		public function deletePoints($id)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt = $db->prepare('UPDATE cip_appointment SET points = NULL WHERE id = :id');
					$stmt->bindValue(':id', $id, PDO::PARAM_INT);
					$stmt->execute();
					if ($stmt->rowCount()>0)
					{
						return 1;
					}
					else
					{
						return 0;
					}
				}
				catch(PDOException $e)
				{
					
					$db = 0;
					return 0;
				}

			}
			else
			{
				
				$db = 0;
				return 0;
			}

		}

	}

?>