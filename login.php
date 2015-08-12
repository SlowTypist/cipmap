<?php
require_once("./includes/auth.php");
require_once("./header.php");
require_once("./controller/UserController.php");
$error_msg = null;
$template_variables = array('title' => 'Login page');
if($_POST["action"] == "Login") {
    $userController = new UserController();
    $result = $userController->login();
    $template_variables["error_msg"] = $result;
}

$template = $twig->loadTemplate('auth/login.html');
echo $template->render($template_variables);
?> 

