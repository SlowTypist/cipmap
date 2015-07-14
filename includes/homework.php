<?php
	include_once(dirname(__DIR__).'/config/config.php');
	include_once dirname(__FILE__).'/db.php';
	include_once(dirname(__DIR__).'/libraries/PHPMailer.php');
	class homework
	{
		public function listAllHomeworks($lecture_id)
		{
			$db = db_connect();
			if ($db)
			{

				try
				{
					$stmt = $db->prepare("SELECT id, name FROM cip_homework WHERE lecture_id=:lecture_id ORDER BY id");
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

	}
?>