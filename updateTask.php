<?php 
include('common.php');
include('classes/class_task.php');

$update= new Task;
echo $update->drawTask('update');

?>