<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 18.08.15
 * Time: 14:54
 */

require_once(dirname(__DIR__).'/model/WorkingHours.php');
require_once(dirname(__DIR__).'/model/WorkingHoursList.php');
class WorkingHoursController{


    public function countFreeSlotOnLocationBetweenDates($location_id, $start, $end){
        $freeSlots = 0;
        if ($start >= date ('Y-m-d', time())){
            $iterday = $start;
        }
        else {
            $iterday = date ('Y-m-d', time());
            $start = $iterday;
        }

        $workingHoursList = new WorkingHoursList();
        $workingHoursList->location_id = $location_id;
        $workingHoursList->getAllFromLocation();


        while (strtotime($iterday) <= strtotime($end)){
            foreach($workingHoursList->list as $key => $value){
                if(date ("N", strtotime($iterday)) != "6" && date ("N", strtotime($iterday)) != "7" &&
                    date ("N", strtotime($iterday)) == $value->day){
                    $freeSlots += $value->close_time - $value->open_time;
                }
            }
            $iterday = date ("Y-m-d", strtotime("+1 day", strtotime($iterday)));

        }
        $freeSlots *= 2;


        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT COUNT( DISTINCT time, location_id ) AS takenslots
										FROM cip_appointment
										WHERE location_id = :location_id
										AND time >= :start
										AND time <= :end");
                $stmt->bindValue(':location_id', $location_id, PDO::PARAM_INT);
                $stmt->bindValue(':start', date ("Y-m-d H:i:s", strtotime($start)), PDO::PARAM_STR);
                $stmt->bindValue(':end', date ("Y-m-d H:i:s", strtotime("+23 hours 59 minutes 59 seconds", strtotime($end))), PDO::PARAM_STR);
                $stmt->execute();
                $res = $stmt->fetch(PDO::FETCH_ASSOC);
                $freeSlots -= $res["takenslots"];

            }
            catch (PDOException $e){
                $db = null;
                return -1;
            }
        }
        else{
            return -1;
        }
        return $freeSlots;
    }

}