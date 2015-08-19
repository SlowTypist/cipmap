<?php
require_once("./includes/refresh_session.php");
require_once("./header.php");

require_once("./controller/LectureController.php");
require_once("./controller/HomeworkController.php");
require_once("./controller/AppointmentController.php");
require_once("./controller/LocationController.php");

if (!isset($_GET["id"])){
    header('Location: home.php');
}

$template_variables = null;
// getting lecture information
$lectureController = new LectureController();
$lectureInfo = $lectureController->lectureInfo($_GET['id']);

if ($lectureInfo->id == 0){
    header('Location: home.php');
}

$template_variables = array('title' => 'Information on lecture '.$lectureInfo->name);
$template_variables["lname"] = $lectureInfo->name;
$template_variables["lteacher"] = $lectureInfo->teacher;
$template_variables["lgs"] =  $lectureInfo->max_group_size;


$homeworkController = new HomeworkController();
$homeworkList = $homeworkController->listAllFromLecture($_GET['id']);
$template_variables["lhw"] =  $homeworkList;

$allPoints = 0;

foreach ($homeworkList as $key => $value ) {

    $allPoints += $value->max_points;

}
$template_variables["lpoints"] =  $allPoints;

$appointmentController = new AppointmentController();
$appointmentList = $appointmentController->listAllFromLecture($_GET['id'], $_SESSION['user']);

$template_variables["apps"] = $appointmentList;

$totalPoints = 0;
foreach ($appointmentList as $key => $value){
    $totalPoints += $value->points;
}

$template_variables["apoints"] = $totalPoints;




$template = $twig->loadTemplate('app/lecture_info.html');
echo $template->render($template_variables);
?> 