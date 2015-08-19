<?php
require_once("./header.php");
require_once("./controller/UserController.php");

if ($_SESSION['loggedin'] == true){
    header('Location: index.php');
}
$template_variables = array('title' => 'Forgot Password Page');

if($_POST["action"] == "Send verification e-mail") {
    $userController = new UserController();
    $result = $userController->forgot();
    $template_variables["type"] = $result["type"];
    $template_variables["message"] = $result["message"];
    $template_variables["email"] = isset($_POST["email"]) ? $_POST["email"] : "@uni-bonn.de";
}

$template = $twig->loadTemplate('auth/forgot.html');
echo $template->render($template_variables);
?> 