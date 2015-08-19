<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 17.08.15
 * Time: 01:59
 */
include_once dirname(__DIR__).'/includes/db.php';
class Homework{
    public $id = 0;
    public $name = "";
    public $lecture_id = "";
    public $start = "";
    public $end = "";
    public $max_points = "";
    public $link_task = "";
    public $link_solution = "";

    public function save(){
        $db = db_connect();
        if ($db){
            try{
                $stmt = $db->prepare("INSERT INTO cip_homework
                                      (id, name, lecture_id, start, end, max_points, link_task, link_solution)
                                      VALUES
                                      (:id, :name, :lecture_id, :start, :end, :max_points, :link_task, :link_solution)");
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':lecture_id', $this->lecture_id);
                $stmt->bindParam(':start', $this->start);
                $stmt->bindParam(':end', $this->end);
                $stmt->bindParam(':max_points', $this->max_points);
                $stmt->bindParam(':link_task', $this->link_task);
                $stmt->bindParam(':link_solution', $this->link_solution);

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
                $stmt = $db->prepare("UPDATE cip_homework
                                      SET name = :name, lecture_id = :lecture_id, start = :start, end = :end,
                                      max_points = :max_points, link_task = :link_task, link_solution = :link_solution
                                      WHERE id = :id");
                $stmt->bindParam(':id', $this->id);
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':lecture_id', $this->lecture_id);
                $stmt->bindParam(':start', $this->start);
                $stmt->bindParam(':end', $this->end);
                $stmt->bindParam(':max_points', $this->max_points);
                $stmt->bindParam(':link_task', $this->link_task);
                $stmt->bindParam(':link_solution', $this->link_solution);

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
                $stmt = $db->prepare("SELECT id, name, lecture_id, start, end, max_points, link_task, link_solution
                                      FROM cip_homework WHERE id = :id");
                $stmt->bindParam(':id', $this->id);
                $stmt->execute();
                // fetching the result
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {
                    $this->id = $result["id"];
                    $this->name = $result["name"];
                    $this->lecture_id = $result["lecture_id"];
                    $this->start = $result["start"];
                    $this->end = $result["end"];
                    $this->max_points = $result["max_points"];
                    $this->link_task = $result["link_task"];
                    $this->link_solution = $result["link_solution"];
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

?>