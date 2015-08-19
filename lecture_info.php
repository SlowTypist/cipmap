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


$lectureController = new LectureController();
$lectureInfo = $lectureController->lectureInfo($_GET['id']);

if ($lectureInfo->id == 0){
    header('Location: home.php');
}

$homeworkController = new HomeworkController();
$homeworkList = $homeworkController->listAllFromLecture($_GET['id']);

$allPoints = 0;

foreach ($homeworkList as $key => $value ) {

    $allPoints += $value->max_points;

}

$appointmentController = new AppointmentController();
$appointmentList = $appointmentController->listAllFromLecture($_GET['id'], $_SESSION['user']);

$totalPoints = 0;
foreach ($appointmentList as $key => $value){
    $totalPoints += $value->points;
}

include("views/lecture_info_view.php");
?> 