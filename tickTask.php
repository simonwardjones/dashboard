<?php
include('common.php');
include('classes/class_task.php');

$tickTask = new Task;
echo $tickTask->drawTask('tick');
?>