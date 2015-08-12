<?php
require_once("./header.php");
require_once("./controller/UserController.php");

if ($_SESSION['loggedin'] == true){
    header('Location: index.php');
}



$template_variables = array('title' => 'Registration');
if($_POST["action"] == "Register") {
    $userController = new UserController();
    $result = $userController->register();
    //$template_variables["error_msg"] = $result;
}

$template = $twig->loadTemplate('auth/register.html');
echo $template->render($template_variables);
?> 