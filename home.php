<?php
require_once("./includes/refresh_session.php");
require_once("./header.php");
require_once("./controller/LectureController.php");

$template_variables = array('title' => 'Home page');
$lectureController = new LectureController();
$allLectures = $lectureController->listAll();
$template_variables["lectures"] = $allLectures;

$template = $twig->loadTemplate('app/home.html');
echo $template->render($template_variables);
?> 