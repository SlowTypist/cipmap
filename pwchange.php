<?php
require_once("./includes/refresh_session.php");
require_once("./header.php");
require_once("./controller/UserController.php");

$template_variables = array('title' => 'Change Password');
if($_POST["action"] == "Change password") {
    $userController = new UserController();
    $result = $userController->changePassword();
    $template_variables["type"] = $result["type"];
    $template_variables["message"] = $result["message"];
}

$template = $twig->loadTemplate('auth/pwchange.html');
echo $template->render($template_variables);
?> 