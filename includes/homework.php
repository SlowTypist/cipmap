<?php
	include_once(dirname(__DIR__).'/config/config.php');
	include_once dirname(__FILE__).'/db.php';
	include_once(dirname(__DIR__).'/libraries/PHPMailer.php');
	class homework
	{
		public function getHomeworkInfo($homework_id)
		{
			$db = db_connect();
			if ($db)
			{

				try
				{
					$stmt = $db->prepare("SELECT id, name, lecture_id, start, end, max_points, link_task, link_solution FROM cip_homework WHERE id=:homework_id");
					$stmt->bindValue(':homework_id', $homework_id, PDO::PARAM_INT);
					$stmt->execute();
					$homeworkinfo = $stmt->fetch(PDO::FETCH_ASSOC);

					return $homeworkinfo;
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
		public function getHomeworkInfoNoSolution($homework_id)
		{
			$db = db_connect();
			if ($db)
			{

				try
				{
					$stmt = $db->prepare("SELECT A.id as lecture_id, A.name as homework_name, A.lecture_id, start, end, max_points, link_task, B.name as lecture_name, B.teacher, B.max_group_size 
											FROM cip_homework A, cip_lecture B 
											WHERE A.id=:homework_id 
											AND B.id = A.lecture_id");
					$stmt->bindValue(':homework_id', $homework_id, PDO::PARAM_INT);
					$stmt->execute();
					$homeworkinfo = $stmt->fetch(PDO::FETCH_ASSOC);

					return $homeworkinfo;
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
		public function getHomeworkLocations($homework_id)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt = $db->prepare("SELECT A.location_id, B.name FROM cip_homework_locations A, cip_location B WHERE A.homework_id=:homework_id AND B.id=A.location_id");
					$stmt->bindValue(':homework_id', $homework_id, PDO::PARAM_INT);
					$stmt->execute();
					$homeworklocation = $stmt->fetchAll(PDO::FETCH_ASSOC);
					return $homeworklocation;
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
		public function listAllHomeworks($lecture_id)
		{
			$db = db_connect();
			if ($db)
			{

				try
				{
					$stmt = $db->prepare("SELECT id, name, start, end, max_points, (link_task != '') AS task_exists FROM cip_homework WHERE lecture_id=:lecture_id ORDER BY id");
					$stmt->bindValue(':lecture_id', $lecture_id, PDO::PARAM_INT);
					$stmt->execute();
					$db = null;
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					return $result;
					$db = null;
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
		public function addHomework($name, $lecture_id, $start, $end, $max_points, $link_task, $link_solution)
		{
			$db = db_connect();
			if($db)
			{
				try
				{
					$stmt = $db->prepare ("	INSERT INTO cip_homework(name, lecture_id, start, end, max_points, link_task, link_solution) 
											VALUES (:name, :lecture_id, :start, :end, :max_points, :link_task, :link_solution)");
					$stmt->bindValue(':name', $name, PDO::PARAM_STR);
					$stmt->bindValue(':lecture_id', $lecture_id, PDO::PARAM_INT);
					$stmt->bindValue(':start', $start, PDO::PARAM_STR);
					$stmt->bindValue(':end', $end, PDO::PARAM_STR);
					$stmt->bindValue(':max_points', $max_points, PDO::PARAM_INT);
					$stmt->bindValue(':link_task', $link_task, PDO::PARAM_STR);
					$stmt->bindValue(':link_solution', $link_solution, PDO::PARAM_STR);
					$stmt->execute();
					$homework_id =$db->lastInsertId();
					if ($stmt)
					{
						return $homework_id;
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
				return 0;
			}

		}
		public function addHomeworkLocation($homework_id, $location_id)
		{
			$db = db_connect();
			if($db)
			{
				try
				{
					$stmt = $db->prepare("INSERT INTO cip_homework_locations(homework_id, location_id) VALUES (:homework_id, :location_id)");
					$stmt->bindValue(':homework_id', $homework_id, PDO::PARAM_INT);
					$stmt->bindValue(':location_id', $location_id, PDO::PARAM_INT);
					$stmt->execute();
					if ($stmt)
					{
						return $db->lastInsertId();
					}
					else
					{
						return 0;
					}

				}
				catch (PDOException $e)
				{
					var_dump($e);
					$db = null;
					return 0;
				}


			}
			else
			{
				return 0;
			}
		}
		public function deleteHomeworkLocations($homework_id)
		{
			$db = db_connect();
			if($db)
			{
				try
				{
					$stmt = $db->prepare("DELETE FROM cip_homework_locations WHERE homework_id = :homework_id");
					$stmt->bindValue(':homework_id', $homework_id, PDO::PARAM_INT);
					$stmt->execute();
					if ($stmt)
					{
						return $db->lastInsertId();
					}
					else
					{
						return 0;
					}

				}
				catch (PDOException $e)
				{
					var_dump($e);
					$db = null;
					return 0;

				}

			}
			else
			{
				return 0;
			}
		}
		public function editHomework($id, $name, $start, $end, $max_points, $link_task, $link_solution)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt = $db->prepare("UPDATE cip_homework SET name = :name, start = :start, end = :end, max_points = :max_points, link_task = :link_task, link_solution = :link_solution WHERE id = :id");
					$stmt->bindValue(':name', $name, PDO::PARAM_STR);
					$stmt->bindValue(':start', $start, PDO::PARAM_STR);
					$stmt->bindValue(':end', $end, PDO::PARAM_STR);
					$stmt->bindValue(':max_points', $max_points, PDO::PARAM_INT);
					$stmt->bindValue(':link_task', $link_task, PDO::PARAM_STR);
					$stmt->bindValue(':link_solution', $link_solution, PDO::PARAM_STR);
					$stmt->bindValue('id', $id, PDO::PARAM_INT);
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
					var_dump($e);
					$db = null;
					return 0;
				}
			}
			else
			{
				return 0;
			}

		}
		public function deleteHomework($homework_id)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{ 
					$stmt = $db->prepare("SELECT lecture_id FROM cip_homework WHERE id=:homework_id");
					$stmt->bindValue(':homework_id', $homework_id, PDO::PARAM_INT);
					$stmt->execute();
					$lecture_id = $stmt->fetch(PDO::FETCH_ASSOC)["lecture_id"];
					$stmt = $db->prepare("DELETE FROM cip_homework WHERE id=:homework_id; DELETE FROM cip_homework_locations WHERE homework_id=:homework_id; DELETE FROM cip_appointment WHERE homework_id = :homework_id");
					$stmt->bindValue(':homework_id', $homework_id, PDO::PARAM_INT);
					$stmt->execute();
					if ($stmt)
					{
						return $lecture_id;
					}
					else 
					{
						return 0;
					}

				}
				catch (PDOException $e)
				{
					var_dump($e);
					$db = null;
					return 0;
				}

			}
			else
			{
				return 0;
			}
		}
		public function getTaskLink($homework_id)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{ 
					$stmt = $db->prepare("SELECT link_task FROM cip_homework WHERE id=:homework_id");
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
		public function allPoints($lecture_id)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{ 
					$stmt = $db->prepare("SELECT SUM(max_points) FROM cip_homework WHERE lecture_id=:lecture_id");
					$stmt->bindValue(':lecture_id', $lecture_id, PDO::PARAM_INT);
					$stmt->execute();
					$result = $stmt->fetch(PDO::FETCH_ASSOC)["SUM(max_points)"];
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

	}
?>