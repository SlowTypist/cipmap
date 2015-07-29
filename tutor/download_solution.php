
<?php
require_once(dirname(__DIR__).'/includes/tutor.php');
session_start();
if ($_SESSION['loggedin'] == true && ($_SESSION['role'] > 0))
{
    $file = "";
    if (isset($_GET["id"]))
    {
    	$tutor = new tutor();
    	$solutionLink = $tutor->getSolutionLink($_GET['id']);
    	$file = "../".$solutionLink["link_solution"];
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
}
else
{
    header('Location: ../login.php');
}
?>
