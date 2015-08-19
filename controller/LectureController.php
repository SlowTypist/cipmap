<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 13.08.15
 * Time: 02:50
 */

require_once(dirname(__DIR__).'/model/Lecture.php');
require_once(dirname(__DIR__).'/model/LectureList.php');
class LectureController{

    public function listAll(){
        $lectureList = new LectureList();

        $lectureList->getAll();
        return $lectureList->list;
    }

    public  function  lectureInfo($id){
        $lecture = new Lecture();
        $lecture->id = $id;

        $lecture->get();

        return $lecture;

    }

}
?>