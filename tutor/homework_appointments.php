<?php
require_once(dirname(__DIR__).'/includes/user.php');
require_once(dirname(__DIR__).'/includes/lecture.php');
require_once(dirname(__DIR__).'/includes/homework.php');
require_once(dirname(__DIR__).'/includes/appointment.php');
include (dirname(__DIR__)."/handlers/homework_appointments_handler.php");
include(dirname(__DIR__)."/views/homework_appointments_view.php");
?> 