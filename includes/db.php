<?php


function db_connect()
/** connects to database */
{

	try
	{
		include(dirname(__DIR__).'/config/config.php');
		$db = new PDO('mysql:host='.$host.';dbname='.$dbname.";charset=utf8", $username, $password);
	}
	catch (PDOException $e)
	{
		var_dump($e);
		return 0;
	}
	return $db;
}

function lock_tables($tables, $db)
{
	try
	{
		$query = "LOCK TABLES";
		foreach($tables as $table)
		{
			$query = $query." ".$table;
			$query = $query." WRITE,";
		}
		$db->exec($query);
		return 1;
	}
	catch(PDOException $e)
	{
		return 0;
	}
}
		
function unlock($db)
{
	try
	{
		$db->exec("UNLOCK TABLES");
		return 1;
	}
	catch(PDOException $e)
	{
		return 0;
	}
}


?>