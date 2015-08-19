<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 18.08.15
 * Time: 02:27
 */
include_once dirname(__DIR__).'/includes/db.php';
class Location{

    public $id = 0;
    public $name = "";

    public function save(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("INSERT INTO cip_location(name)
                                      VALUES (:name)");
                $stmt->bindParam(':name', $this->name);
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
                $stmt = $db->prepare("UPDATE cip_location
                                      SET name = :name
                                      WHERE id = :id");
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':name', $this->name);

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
                $stmt = $db->prepare("SELECT id,name
                                      FROM cip_location WHERE id = :id");
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
                // fetching the result
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $this->id = $result["id"];
                    $this->name = $result["name"];
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