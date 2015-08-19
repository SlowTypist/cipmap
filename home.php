<?php
require_once("./includes/refresh_session.php");
require_once("./header.php");
require_once("./controller/LectureController.php");

$lectureController = new LectureController();
$allLectures = $lectureController->listAll();

include("views/student1_view.php");
?> 