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
					$stmt = $db->prepare("SELECT name  FROM cip_location WHERE id = :id");
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
		public function getWorkingHours($id)
		{
			$db = db_connect();
			if($db)
			{
				try
				{
					$stmt = $db->prepare("SELECT day, open_time, close_time FROM cip_working_hours WHERE location_id = :id");
					$stmt->bindValue(':id', $id, PDO::PARAM_INT);
					$stmt->execute();
					$db = null;
					$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
					return $result;
				}
				catch (PDOException $e)
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
		public function changeWorkingHours($id, $boxes) 	//very monstrous function that makes the correct working times
		{
			$currentOpen = strtotime('08:00:00');
			$currentClosed = strtotime('09:00:00');
			$currentsetopen = 0;
			
			$db = db_connect();
			if ($db)
			{
				try
				{
					$stmt = $db->prepare ("DELETE FROM cip_working_hours WHERE location_id = :location_id");
					$stmt->bindValue(':location_id', $id, PDO::PARAM_INT);
					$stmt->execute();

				}
				catch (PDOException $e)
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

			for ($i = 0; $i < count($boxes); $i++)
			{
				if ($boxes[$i] == 13 || $boxes[$i] == 26 || $boxes[$i] == 39 || $boxes[$i] == 52 || (($boxes[$i]-$boxes[$i-1])>1 && $i != 0) || $i == count($boxes)-1)
				{
					$currentsetopen = 0;
					if ($i == count($boxes)-1)
					{
						$currentClosed = strtotime($currentClosed) + 60*60;
						$currentClosed = date('H:i:s', $currentClosed);
					}
					try
					{
						$stmt = $db->prepare ("INSERT INTO cip_working_hours (location_id, day, open_time, close_time) 
												VALUES (:location_id, :day, :open, :closed)");
						$stmt->bindValue(':location_id', $id, PDO::PARAM_INT);
						$stmt->bindValue(':open', $currentOpen, PDO::PARAM_STR);
						$stmt->bindValue(':closed', $currentClosed, PDO::PARAM_STR);
						if((intval($boxes[$i-1]/13)) == 0)
						{
							$stmt->bindValue(':day', 'MONDAY', PDO::PARAM_STR);
						}
						else if((intval($boxes[$i-1]/13)) == 1)
						{
							$stmt->bindValue(':day', 'TUESDAY', PDO::PARAM_STR);							
						}
						else if((intval($boxes[$i-1]/13)) == 2)
						{
							$stmt->bindValue(':day', 'WEDNESDAY', PDO::PARAM_STR);							
						}
						else if((intval($boxes[$i-1]/13)) == 3)
						{
							$stmt->bindValue(':day', 'THURSDAY', PDO::PARAM_STR);							
						}
						else if((intval($boxes[$i-1]/13)) == 4)
						{
							$stmt->bindValue(':day', 'FRIDAY', PDO::PARAM_STR);							
						}												
						$stmt->execute();
					}
					catch (PDOException $e)
					{	
						var_dump($e);
						return 0;
					}
					$currentOpen = strtotime('08:00:00');
					$currentClosed = strtotime('09:00:00');
				}
				if ($currentsetopen == 0)
				{
					$currentsetopen = 1;
					$currentOpen = $currentOpen + 60*60*($boxes[$i] - 13*(intval($boxes[$i]/13)));
					$currentOpen = date('H:i:s', $currentOpen);
					$currentClosed = $currentClosed + 60*60*($boxes[$i] - 13*(intval($boxes[$i]/13)));
					$currentClosed = date('H:i:s', $currentClosed);
				}
				else if ($currentsetopen == 1)
				{
					$currentClosed = strtotime($currentClosed) + 60*60;
					$currentClosed = date('H:i:s', $currentClosed);
				}
			}
			return 1;
		}
	}
?>