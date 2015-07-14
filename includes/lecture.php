<?php
	include(dirname(__DIR__).'/config/config.php');
	include_once dirname(__FILE__).'/db.php';

	class lecture
	{
		public function getLectureInfo($id)
		{
			$db = db_connect();
			if($db)
			{
				try
				{
					$stmt = $db->prepare("SELECT name, teacher, max_group_size FROM cip_lecture WHERE id = :id");
					$stmt->bindValue(':id', $id, PDO::PARAM_INT);
					$stmt->execute();
					$db = null;
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					return $result;

				}
				catch (PDOException $e)
				{
					$db =  null;
					return 0;
				}
			}
			else
			{
				$db = null;
				return 0;
			}

		}
		public function listAlllectures()
		{
			$db = db_connect();
			if ($db)
			{

				try
				{
					$stmt = $db->prepare("SELECT id, name FROM cip_lecture ORDER BY id DESC");
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
		public function addLecture($name, $teacher, $max_group_size)
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt= $db->prepare("INSERT INTO cip_lecture(name, teacher, max_group_size) VALUES (:name, :teacher, :max_group_size)");
					$stmt->bindValue(':name', $name, PDO::PARAM_STR);
					$stmt->bindValue(':teacher', $teacher, PDO::PARAM_STR);
					$stmt->bindValue(':max_group_size', $max_group_size, PDO::PARAM_INT);
					$stmt->execute();
					$lecture_id =$db->lastInsertId();
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