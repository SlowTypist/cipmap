<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 17.08.15
 * Time: 19:19
 */

require_once(dirname(__DIR__).'/model/Homework.php');
require_once(dirname(__DIR__).'/model/HomeworkList.php');
class HomeworkController{

    public function listAllFromLecture($lecture_id){
        $homeworkList = new HomeworkList();
        $homeworkList->lecture_id = $lecture_id;

        $homeworkList->getAll();

        return $homeworkList->list;

    }
    public function homeworkInfo($id){
        $homework = new Homework();
        $homework->id = $id;

        $homework->get();

        return $homework;
    }
}

?>