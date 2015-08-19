<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 17.08.15
 * Time: 02:36
 */
include_once dirname(__DIR__).'/includes/db.php';
class Appointment{
    public $id = 0;
    public $time = "";
    public $homework_id = "";
    public $location_id = "";
    public $user_id = "";
    public $code = "";
    public $points = "";


    public function get(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT id, time, homework_id, location_id, user_id, code, points
                                      FROM cip_appointment
                                      WHERE id = :id
                                      AND user_id = :user_id");
                $stmt->bindParam(':user_id', $this->user_id);
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
                // fetching the result
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $this->id = $result["id"];
                    $this->time = $result["time"];
                    $this->homework_id = $result["homework_id"];
                    $this->location_id = $result["location_id"];
                    $this->user_id = $result["user_id"];
                    $this->code = $result["code"];
                    $this->points = $result["points"];
                }
                else{
                    $this->id = 0;
                }
            }
            catch(PDOException $e){
                $db = null;
                $this->id = -1;
            }
        }
        else
        {
            $this->id = -1;		//db error
        }


    }

}