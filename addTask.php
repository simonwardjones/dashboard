<?php 
include "common.php";
include('classes/class_task.php');

$addTask = new Task;
echo $addTask->drawTask('add');

?>