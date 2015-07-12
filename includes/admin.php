<?php
	include_once(dirname(__DIR__).'/config/config.php');
	include_once dirname(__FILE__).'/db.php';
	include_once(dirname(__DIR__).'/libraries/PHPMailer.php');
	class admin
	{
		public function addLocation($name)
		//0 db problem, id - success
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt = $db->prepare("INSERT INTO cip_location(name) VALUES (:name)");
					$stmt->bindValue(':name', $name, PDO::PARAM_STR);
					
					$stmt->execute();
					$location_id =$db->lastInsertId();
					if ($stmt)
					{
						return $location_id;
					}
				}
				catch(PDOException $e)
				{
					$db = null;
					return 0;
				}
			}
			else
			{
				$db = null;
				return 0;
			}
		}
		public function editLocation($id, $name)
		// 0 db problem, 1 - success
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt = $db->prepare("UPDATE cip_location
										SET name = :name
										WHERE id = :id");
					$stmt->bindValue(':id', $id, PDO::PARAM_INT);
					$stmt->bindValue(':name', $name, PDO::PARAM_STR);
					$stmt->execute();
					if ($stmt)
					{
						$db = null;
						return 1;
					}
					else
					{
						$db = null;
						return 0;
					}

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
		public function deleteLocation($id)
		// 0 db problem, 1 - success
		{
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt = $db->prepare("DELETE FROM cip_location
										WHERE id = :id");
					$stmt->bindValue(':id', $id, PDO::PARAM_INT);
					$stmt->execute();
					if ($stmt)
					{
						$db = null;
						return 1;
					}
					else
					{
						$db = null;
						return 0;
					}

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
		public function listAllLocations()
		{
			$db = db_connect();
			if($db)
			{
				try
				{
					$stmt = $db->prepare("SELECT id, name  FROM cip_location ORDER BY name");
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
		public function getLocationName($id)
		{
			$db = db_connect();
			if($db)
			{
				try
				{
					$stmt = $db->prepare("SELECT name  FROM cip_location WHERE id = :id ORDER BY name");
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
	}
?>