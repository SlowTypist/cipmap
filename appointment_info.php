<?php

require_once("./includes/refresh_session.php");
require_once("./header.php");

require_once("./controller/LectureController.php");
require_once("./controller/HomeworkController.php");
require_once("./controller/AppointmentController.php");
require_once("./controller/LocationController.php");
require_once("./controller/WorkingHoursController.php");

if (!isset($_GET["h"]) && !isset($_GET['id']) && !isset($_POST['action'])){
    header('Location: home.php');
}
else if(isset($_GET['id'])){
    $appointmentController = new AppointmentController();
    $homeworkController = new HomeworkController();
    $lectureController = new LectureController();
    $locationController = new LocationController();

    $appointmentInfo = $appointmentController->getAppointmentInfo($_GET['id'], $_SESSION['user']);
    if ($appointmentInfo->id == 0) {

        header('Location: home.php');

    }

    $homeworkInfo = $homeworkController->homeworkInfo($appointmentInfo->homework_id);

    $lectureInfo = $lectureController->lectureInfo($homeworkInfo->lecture_id);

    $locationInfo = $locationController->locationInfo($appointmentInfo->location_id);

    $teammates = $appointmentController->getTeammates($appointmentInfo->code);
}
else if(isset($_GET['h'])){
    $homeworkController = new HomeworkController();
    $lectureController = new LectureController();
    $locationController = new LocationController();
    $workingHours = new WorkingHoursController();
    $freeSlots = array();

    $homeworkInfo = $homeworkController->homeworkInfo($_GET['h']);

    $lectureInfo = $lectureController->lectureInfo($homeworkInfo->lecture_id);

    $allAvailableLocations = $locationController->listAllAvailable($_GET['h']);

    foreach($allAvailableLocations as $key => $value){
        array_push($freeSlots, $workingHours->countFreeSlotOnLocationBetweenDates($value->id, $homeworkInfo->start, $homeworkInfo->end));
    }
}
else if($_POST['action'] == 'Choose day'){
    $homeworkController = new HomeworkController();
    $lectureController = new LectureController();
    $locationController = new LocationController();
    $workingHours = new WorkingHoursController();

    $availableDays = array();
    $dayData = array();

    $homeworkInfo = $homeworkController->homeworkInfo($_POST['h']);

    $lectureInfo = $lectureController->lectureInfo($homeworkInfo->lecture_id);

    $locationInfo = $locationController->locationInfo($_POST['location_id']);

    if ($homeworkInfo->start >= date ('Y-m-d', time())){
        $iterday = $homeworkInfo->start;
    }
    else{
        $iterday = date ('Y-m-d', time());
    }
    while (strtotime($iterday) <= strtotime($homeworkInfo->end)){
        if(date ("D", strtotime($iterday)) != "Sat" && date ("D", strtotime($iterday)) != "Sun" ){
            $dayData["day"] = date ("Y-m-d", strtotime($iterday));
            $dayData["slots"] = $workingHours->countFreeSlotOnLocationBetweenDates($locationInfo->id,date ("Y-m-d", strtotime($iterday)), date ("Y-m-d", strtotime($iterday)));
            array_push($availableDays, $dayData);
        }
        $iterday = date ("Y-m-d", strtotime("+1 day", strtotime($iterday)));
    }

}

//require_once('includes/user.php');
//require_once('includes/lecture.php');
//require_once('includes/homework.php');
//require_once('includes/location.php');
//require_once('includes/appointment.php');
//include ("handlers/appointment_info_handler.php");
include("views/appointment_info_view.php");
?> 