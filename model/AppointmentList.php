<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 17.08.15
 * Time: 19:03
 */
include_once dirname(__DIR__).'/includes/db.php';
include_once 'Appointment.php';
class AppointmentList{

    public $list = array();
    public $lecture_id = 0;
    public $user_id = 0;
    public $code = "";

    public function getAll(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT A.id, A.time, A.homework_id, A.location_id, A.user_id, A.code,A.points
                                      FROM cip_appointment A, cip_homework B
                                      WHERE A.homework_id = B.id
                                      AND A.user_id = :user_id
                                      AND B.lecture_id = :lecture_id
                                      ORDER BY id ASC");
                $stmt->bindParam(':lecture_id', $this->lecture_id);
                $stmt->bindParam(':user_id', $this->user_id);

                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $appointment = new Appointment();
                    $appointment->id = $row['id'];
                    $appointment->time = $row['time'];
                    $appointment->homework_id = $row['homework_id'];
                    $appointment->location_id = $row['location_id'];
                    $appointment->user_id = $row['user_id'];
                    $appointment->code = $row['code'];
                    $appointment->points = $row['points'];
                    array_push($this->list, $appointment);
                }

            }
            catch (PDOException $e){
                $this->homework_id = -1;		//db error
            }
        }
        else{
            $this->homework_id = -1;		//db error
        }

    }

    public function getByCode(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT A.id, A.time, A.homework_id, A.location_id, A.user_id, A.code,A.points
                                      FROM cip_appointment A
                                      WHERE A.code = :code
                                      ORDER BY id ASC");
                $stmt->bindParam(':code', $this->code);

                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $appointment = new Appointment();
                    $appointment->id = $row['id'];
                    $appointment->time = $row['time'];
                    $appointment->homework_id = $row['homework_id'];
                    $appointment->location_id = $row['location_id'];
                    $appointment->user_id = $row['user_id'];
                    $appointment->code = $row['code'];
                    $appointment->points = $row['points'];
                    array_push($this->list, $appointment);
                }

            }
            catch (PDOException $e){
                $this->homework_id = -1;		//db error
            }
        }
        else{
            $this->homework_id = -1;		//db error
        }
    }



}