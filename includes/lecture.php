<?php
	include(dirname(__DIR__).'/config/config.php');
	include_once dirname(__FILE__).'/db.php';

	class lecture
	{
		public function listAlllectures()
		{
			$db = db_connect();
			if ($db)
			{

				try
				{
					$stmt = $db->prepare("SELECT id, name FROM cip_lecture");
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

	}

?>