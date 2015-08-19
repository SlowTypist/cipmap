<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 18.08.15
 * Time: 13:38
 */
include_once dirname(__DIR__).'/includes/db.php';
include_once 'Location.php';
class LocationList{
    public $list = array();
    public $homework_id = 0;


    public function getAll(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT id, name
                                      FROM cip_location
                                      ORDER BY id ASC");

                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $location = new Location();
                    $location->id = $row['id'];
                    $location->name = $row['name'];
                    array_push($this->list, $location);
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

    public function getAllFromHomework(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("SELECT A.id, A.name
                                      FROM cip_location A, cip_homework_locations B
                                      WHERE A.id = B.location_id
                                      AND B.homework_id = :homework_id
                                      ORDER BY id ASC");
                $stmt->bindParam(':homework_id', $this->homework_id);

                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $location = new Location();
                    $location->id = $row['id'];
                    $location->name = $row['name'];
                    array_push($this->list, $location);
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