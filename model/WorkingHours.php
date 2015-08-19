<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 18.08.15
 * Time: 14:32
 */

include_once dirname(__DIR__).'/includes/db.php';
class WorkingHours{
    public $id = 0;
    public $location_id = "";
    public $day = "";
    public $open_time = "";
    public $close_time = "";

    public function save(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("INSERT INTO cip_working_hours(location_id, day, open_time, close_time)
                                      VALUES (:location_id, :day, :open_time, :close_time)");
                $stmt->bindParam(':location_id', $this->location_id);
                $stmt->bindParam(':day', $this->day);
                $stmt->bindParam(':open_time', $this->open_time);
                $stmt->bindParam(':close_time', $this->close_time);
                $stmt->execute();

                $this->id = $db->lastInsertId();
            }
            catch (PDOException $e){
                $db = null;
                $this->id = -1;
            }
        }
        else
        {
            $this->id = -1;		//db error
        }

    }
    public function update(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("UPDATE cip_working_hours
                                      SET location_id = :location_id,
                                      day = :day,
                                      open_time = :open_time,
                                      close_time = :close_time
                                      WHERE id = :id");
                $stmt->bindParam(':location_id', $this->location_id);
                $stmt->bindParam(':day', $this->day);
                $stmt->bindParam(':open_time', $this->open_time);
                $stmt->bindParam(':close_time', $this->close_time);

                $stmt->execute();

                if ($stmt->rowCount() < 1){
                    $this->id = 0;
                }
            }
            catch(PDOException $e){
                $this->id = -1;
            }

        }
        else
        {
            $this->id = -1;		//db error
        }
    }
    public function get(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT id,location_id, day, open_time, close_time
                                      FROM cip_working_hours
                                      WHERE id = :id");
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
                // fetching the result
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $this->id = $result["id"];
                    $this->location_id = $result["location_id"];
                    $this->day = $result["day"];
                    $this->open_time = $result["open_time"];
                    $this->close_time = $result["close_time"];
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