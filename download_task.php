
<?php
require_once('includes/homework.php');
$file = "";
if (isset($_GET["id"]))
{
	$homework = new homework();
	$taskLink = $homework->getTaskLink($_GET['id']);
	$file = $taskLink["link_task"];
}
else 
{
	header('Location: index.php');
}
if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
 	flush();
    readfile($file);
    exit;
}
else 
{
	echo "The file doesn't exist";
}

?>
