<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 18.08.15
 * Time: 14:43
 */

include_once dirname(__DIR__).'/includes/db.php';
include_once 'WorkingHours.php';
class WorkingHoursList{
    public $list = array();
    public $location_id = 0;
    public $day = 0;


    public function getAll(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT id, location_id, day, open_time, close_time
                                      FROM cip_working_hours
                                      ORDER BY day ASC");

                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $working_hours = new WorkingHours();
                    $working_hours->id = $row['id'];
                    $working_hours->location_id = $row['location_id'];
                    $working_hours->day = $row['day'];
                    $working_hours->open_time = $row['open_time'];
                    $working_hours->close_time = $row['close_time'];
                    array_push($this->list, $working_hours);
                }

            }
            catch (PDOException $e){
                $this->list = -1;		//db error
            }
        }
        else{
            $this->list = -1;		//db error
        }

    }

    public function getAllFromLocation(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT id, location_id, day, open_time, close_time
                                      FROM cip_working_hours
                                      WHERE location_id = :location_id
                                      ORDER BY day ASC");
                $stmt->bindParam(':location_id', $this->location_id);

                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $working_hours = new WorkingHours();
                    $working_hours->id = $row['id'];
                    $working_hours->location_id = $row['location_id'];
                    $working_hours->day = $row['day'];
                    $working_hours->open_time = $row['open_time'];
                    $working_hours->close_time = $row['close_time'];
                    array_push($this->list, $working_hours);
                }

            }
            catch (PDOException $e){
                $this->list = -1;		//db error
            }
        }
        else{
            $this->list = -1;		//db error
        }

    }
    public function getAllFromLocationFromDay(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT id, location_id, day, open_time, close_time
                                      FROM cip_working_hours
                                      WHERE location_id = :location_id
                                      AND day = :day
                                      ORDER BY day ASC");
                $stmt->bindParam(':location_id', $this->location_id);
                $stmt->bindParam(':day', date('N', strtotime($this->day)));

                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $working_hours = new WorkingHours();
                    $working_hours->id = $row['id'];
                    $working_hours->location_id = $row['location_id'];
                    $working_hours->day = $row['day'];
                    $working_hours->open_time = $row['open_time'];
                    $working_hours->close_time = $row['close_time'];
                    array_push($this->list, $working_hours);
                }

            }
            catch (PDOException $e){
                $this->list = -1;		//db error
            }
        }
        else{
            $this->list = -1;		//db error
        }

    }

}