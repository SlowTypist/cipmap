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
    $template_variables["type"] = $result["type"];
    $template_variables["message"] = $result["message"];
    $template_variables["email"] = isset($_POST["email"]) ? $_POST["email"] : "@uni-bonn.de";
    $template_variables["name"] = isset($_POST["name"]) ? $_POST["name"] : "";
    $template_variables["surname"] = isset($_POST["surname"]) ? $_POST["surname"] : "";
    $template_variables["matrnr"] = isset($_POST["matrnr"]) ? $_POST["matrnr"] : "";
}

$template = $twig->loadTemplate('auth/register.html');
echo $template->render($template_variables);
?> 