<?php 
include('common.php');
include('classes/class_task.php');

$taskPage = new Task;
echo $taskPage->drawTask();

//include "renderTaskTable.php";
//echo renderTaskTable();

?>