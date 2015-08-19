<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 17.08.15
 * Time: 20:06
 */
require_once(dirname(__DIR__).'/model/Appointment.php');
require_once(dirname(__DIR__).'/model/AppointmentList.php');

require_once(dirname(__DIR__).'/model/User.php');

class AppointmentController{

    public function createAppointment($day, $time, $homework_id, $location_id, $user_id, $code = NULL){
        $appointment = new Appointment();
        $appointment->time = date ("Y-m-d H:i:s", strtotime($day." ".$time));
        $appointment->homework_id;
        $appointment->location_id;
        $appointment->user_id;
        if (!isset($code)){
            $appointment->code = sha1(uniqid(mt_rand(), true)).strtotime($appointment->time);
        }
        else{
            $appointment->code = $code;
        }

    }

    public function listAllFromLecture($lecture_id, $user_id){
        $appointmentList = new AppointmentList();
        $appointmentList->lecture_id = $lecture_id;
        $appointmentList->user_id = $user_id;

        $appointmentList->getAllFromLectureFromUser();

        return $appointmentList->list;

    }

    public function getAppointmentInfo($id, $user_id){
        $appointment = new Appointment();
        $appointment->id = $id;
        $appointment->user_id = $user_id;


        $appointment->get();

        return $appointment;
    }
    public function isTimeslotOpen($location_id, $day,  $time){
        $appointmentList = new AppointmentList();
        $appointmentList->location_id = $location_id;
        $appointmentList->time = $day." ".$time;

        $appointmentList->getAllFromLocationAndTime();

        if(empty($appointmentList->list)){
            return true;
        }
        else {
            return false;
        }
    }

    public function getTeammates($code){
        $teammates = array();
        $appointmentList = new AppointmentList();
        $appointmentList->code = $code;

        $appointmentList->getByCode();

        foreach ($appointmentList->list as $key => $value){
            $user = new User();
            $user->id = $value->user_id;

            $user->get();

            array_push($teammates, $user);
        }

        return $teammates;
    }


}