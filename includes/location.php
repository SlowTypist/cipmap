<?php
	include_once(dirname(__DIR__).'/config/config.php');
	include_once dirname(__FILE__).'/db.php';
	include_once(dirname(__DIR__).'/libraries/PHPMailer.php');

	class location
	{
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
	}

?>