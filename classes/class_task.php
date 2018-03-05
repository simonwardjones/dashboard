<?php 

class Task{
	public $name='';
	public $loginUser='';
	public $loginPassword='';
	public $taskid=0;
	public $taskDescription='';
	public $ticked = 0;
	
	public function __construct($action){
		$this->loginUser=(isset($_GET['loginUser'])?$_GET['loginUser']:'');
		$this->loginPassword=(isset($_GET['loginPassword'])?$_GET['loginPassword']:'');
		$this->taskDescription = (isset($_GET['taskDescription'])?$_GET['taskDescription']:'');
		$this->taskid = (isset($_GET['taskid'])?$_GET['taskid']:'');
		$this->ticked = (isset($_GET['ticked'])?$_GET['ticked']: 0);
	}
	
	public function drawTask($action){
		$name = $this->loginUser;
		$rtn='';
		$tasks=[];
		
		//if available set variables from GET array
		switch($action){
			case 'update':
				$this->updateTask();
				break;
				
			case 'tick':
				$this->tickTask();
				break;
				
			case 'add':
				$this->addTask();
				break;
				
		}
		
		$dbconn = openDb();
		$sql = "SELECT * FROM task WHERE task_name='".$name."'";
		$result = $dbconn->query($sql);
		while($row=$result->fetch_assoc()){
			if($row['task_name']==$name){
				$tasks[$row['task_id']]['task_description']=$row['task_description'];
				$tasks[$row['task_id']]['task_name']=$row['task_name'];
				$tasks[$row['task_id']]['task_complete']=$row['task_complete'];
				$tasks[$row['task_id']]['task_id']=$row['task_id'];
			}
		}
		ksort($tasks);
		
		$rtn.='<input type="hidden" name="loginUser" id="loginUser" value="'.$this->loginUser.'"/>'
			.'<input type="hidden" name="loginPassword" id="loginPassword" value="'.$this->loginPassword.'"/>'
			.'<input type="hidden" name="nav" id="nav" value=""/>'
			.'<div onclick="login()" class="pageTitle"><- Tasks</div>'
			.'<table class="taskPageTable">';
			
		foreach($tasks as $key=>$value){
			$rtn.='<tr><td class="taskPageDescription">'
					.'<div id="taskDescriptionDiv'.$tasks[$key]['task_id'].'">'
						.'<input class="editTaskDescription" id="taskDescription'.$tasks[$key]['task_id'].'" onchange="updateTask('.$tasks[$key]['task_id'].')" value="'.$tasks[$key]['task_description'].'"/>'
					.'</div>'
				.'</td><td class="taskComplete">'
					.'<div onclick="toggleTask('.$tasks[$key]['task_id'].')" class="taskCheckContainer">'
				.'<span class="taskCheckbox" ></span>'
				.'<span id="tickContainer'.$tasks[$key]['task_id'].'" class="taskPageTick">';
			
			if($tasks[$key]['task_complete']=='1'){
				$rtn.='&#10004;';
			}
			
			$rtn.='</span></div></td></tr>';
		}
		$rtn.='<tr><td><div><img onclick="addTask()" src="http://thepurplepeople.co.uk/Assets/Plus_button_small" /></div></td><tr>'
			.'</table>';
			
		return $rtn;
	}
	
	public function updateTask(){
		$taskid = $this->taskid;
		$taskDescription = $this->taskDescription;

		$dbConn=openDb();
		if($taskDescription==''){
			$sql="DELETE FROM task WHERE task_id = ".$taskid.";";
		}else{
			$sql="UPDATE task SET task_description = '".$taskDescription."' WHERE task_id = ".$taskid.";";
		}
		$dbConn->query($sql);
		$dbConn->close();
	}
	
	public function tickTask(){
		$taskid = $this->taskid;
		$ticked = $this->ticked;
		
		$dbconn=openDb();
		if($ticked!=''){
			$sql="UPDATE task SET task_complete = '0' WHERE task_id = ".$taskid.";";
		} else {
			$sql="UPDATE task SET task_complete = '1' WHERE task_id = ".$taskid.";";
		}
			$dbconn->query($sql);
			$dbconn->close();
	}
	
	public function addTask(){
		$name = $this->loginUser;

		$sql="INSERT INTO task (task_id, task_name, task_description, task_complete) VALUES (NULL, '".$name."', ' ', '0');";
		$dbConn=openDb();
		$dbConn->query($sql);
	}
}

?>