<?php
include "common.php";
include "home.php";

//intitalise variables////////////
$name='';
$loginUser='';
$loginPassword='';
$userlon='';
$userlat='';

//if available set variables from GET array
$loginUser=(isset($_GET['loginUser'])?$_GET['loginUser']:'');
$loginPassword=(isset($_GET['loginPassword'])?$_GET['loginPassword']:'');
$name = $loginUser;
//unnecessary check
$dbconn = openDb();
if($loginPassword!='' && $loginUser!=''){
	$sql="SELECT * FROM Ajax WHERE name = '".$loginUser."' AND password='".$loginPassword."'";
	$result = $dbconn->query($sql);
	while($row = $result->fetch_assoc()){
		$name = $row['name'];
	}
}
$dbconn->close();

//unavailable without a secure connection
$userlon=(isset($_GET['userlon'])?$_GET['userlon']:$userlon);
$userlat=(isset($_GET['userlat'])?$_GET['userlat']:$userlat);

//if GET unavailable set variables from db
$dbconn=openDb();
if($userlon=='' && $userlat==''){
	$sql="SELECT * FROM Ajax LEFT JOIN weather on name=weather_name where weather_name='".$loginUser."'";
	$result = $dbconn->query($sql);
	while($row = $result->fetch_assoc()){
		$userlon=$row['weather_lon'];
		$userlat=$row['weather_lat'];
	}
}
//if db unavailable set variables as
if($userlon=='' && $userlat==''){
	$userlon='-0.13';
	$userlat='51.51';
}

//update db
$sql="UPDATE weather SET weather_lon = '".$userlon."', weather_lat = '".$userlat."'  WHERE weather_name = '".$loginUser."';";
$dbconn->query($sql);
$dbconn->close();

//initialise complete////////////////

function weather($userlat,$userlon){
	$weatherRequest = 'http://api.openweathermap.org/data/2.5/weather?units=metric&lat='.$userlat.'&lon='.$userlon.'&appid=d0a10211ea3d36b0a6423a104782130e';

	$weatherResponse  = file_get_contents($weatherRequest);
	$weatherJson  = json_decode($weatherResponse);
	
	if($weatherJson->weather[0]->id<800){
		$weatherId='rain';
		$weatherBg='http://thepurplepeople.co.uk/Assets/Rain_icon.png';
	}else if($weatherJson->weather[0]->id==800 || $weatherJson->weather[0]->id==804){
		$weatherId='sun';
		$weatherBg='http://thepurplepeople.co.uk/Assets/Sun_icon.png';
	}else{
		$weatherId='cloud';
		$weatherBg='http://thepurplepeople.co.uk/Assets/Clouds_icon.png';
	}
	
	$rtn='<table class="dashContainerTable">'
			.'<tr>'
			.'<td >'
				.'<div>'.round($weatherJson->main->temp).'<div>'
				.'<div>degrees<div>'
			.'</td><td >'
			.	'<div><img src="'.$weatherBg.'"></div>'
			.'</td></tr>'
			.'<tr><td  colspan="2">'
				.'<div>'.$weatherJson->name.'</div>'
			.'</td></tr>'
		.'</table>';
		
	return $rtn;
}

function news(){
	$url="http://feeds.bbci.co.uk/news/rss.xml";
	$xmlObject = simplexml_load_file($url);

	$newsTitle = $xmlObject->channel->item[0]->title;
	$newsDescription = $xmlObject->channel->item[0]->description;
	
	$rtn='<table class="dashContainerTable">'
			.'<tr>'
			.'<td class="dashHeadline">'
				.'<div >'.$newsTitle.'<div>'
			.'</td></tr>'
			.'<tr><td class="dashDescription">'
				.'<div>'.$newsDescription.'</div>'
			.'</td></tr>'
		.'</table>';
	return $rtn;
}

function sport(){
	$url="http://feeds.bbci.co.uk/sport/rss.xml";
	$xmlObject = simplexml_load_file($url);

	$sportTitle = $xmlObject->channel->item[0]->title;
	$sportDescription = $xmlObject->channel->item[0]->description;
	
	$rtn='<table class="dashContainerTable">'
			.'<tr>'
			.'<td class="dashHeadline">'
				.'<div>'.$sportTitle.'<div>'
			.'</td></tr>'
			.'<tr><td class="dashDescription">'
				.'<div>'.$sportDescription.'</div>'
			.'</td></tr>'
		.'</table>';
		
	return $rtn;
}

function photos(){
	
}

function tasks($name){
	$rtn='';
	$tasks=[];
	$dbconn=openDb();
	$sql = "SELECT * FROM task WHERE task_name='".$name."'";
	$result=$dbconn->query($sql);
	while($row=$result->fetch_assoc()){
		if($row['task_name']==$name){
			$tasks[$row['task_id']]['task_description']=$row['task_description'];
			$tasks[$row['task_id']]['task_name']=$row['task_name'];
			$tasks[$row['task_id']]['task_complete']=$row['task_complete'];
			$tasks[$row['task_id']]['task_id']=$row['task_id'];
			
		}
	}
	ksort($tasks);
	foreach($tasks as $key=>$value){
		//echo $tasks[$key]['task_description'];
	}
	$rtn.='<table class="taskTable">';
	foreach($tasks as $key=>$value){
		$rtn.='<tr><td class="taskDescription">'
				.'<div >'.$tasks[$key]['task_description'].'</div>'
			.'</td><td class="taskComplete">'
			.'<div onclick="toggleTask('.$tasks[$key]['task_id'].')" class="taskCheckContainer">'
			.'<span class="taskCheckbox" ></span>'
			.'<span id="tickContainer'.$tasks[$key]['task_id'].'" class="taskTick">';
			if($tasks[$key]['task_complete']=='1'){
				$rtn.='&#10004;';
			}
			$rtn.='</span></div></td></tr>';
	}
	$rtn.='</table>';
	return $rtn;
}

function clothes($name){	
/*
	$clothesRequest = 'https://therapy-box.co.uk/hackathon/clothing-api.php?username=swapnil';
	$clothesResponse  = file_get_contents($clothesRequest);
	$clothesJson  = json_decode($clothesResponse);
	
	for($i=0;$i<1000;$i++){
		$clothes[$clothesJson->payload[$i]->clothe][] = $clothesJson->payload[0]->id;
	}
	foreach($clothes as $key=>$value){
		$clothesRad[$key] = count($value)/1000*2*pi();
		//$clothesRad[$key] = count($value)/1000*360;
	}
	//echo implode($clothesRad);
	$xc=200;
	$yc=200;
	$r=180;
	$cumulativeRad=0-pi()/2;
	
	$clothesLine=implode(",",$clothesRad);
	
	$SVGData='<?xml version="1.0" encoding="utf-8"?>'."\n"
			.'<!-- Generator: Adobe Illustrator 16.0.4, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->'."\n"
			.'<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">'."\n"
			.'<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"'."\n"
				.'width="400px" height="400px" viewBox="0 0 400 400" enable-background="new 0 0 400 400"'."\n"
				.'xml:space="preserve">'."\n"
				."\n";
	//if last login is not today then...
	foreach($clothesRad as $key=>$value){
		$startRad=$cumulativeRad;
		
		$x1=$xc+$r*cos($startRad);
		$y1=$yc+$r*sin($startRad);
		
		$cumulativeRad+=$value;
		
		$x2=$xc+$r*cos($cumulativeRad);
		$y2=$yc+$r*sin($cumulativeRad);
		
		$SVGData.='<path d="M '.$xc.' '.$yc.' 
							L '.$x1.' '.$y1.'
							A '.$xc.' '.$yc.',0,0,1,'.$x2.' '.$y2.' 
							L '.$xc.' '.$yc.' Z" 
							stroke="white"
							fill="rgb('.rand(100,255).','.rand(100,255).','.rand(100,255).')"/>';
							
		//$SVGData.='<text x="'.$x1.'" y="'.$y1.'" font-size="30">'.$key.'</text>';
	}
	$SVGData.='</svg>';
	
	$fileLocation = getenv("DOCUMENT_ROOT") . "/charts/".$name."pie.svg";
	$file = fopen($fileLocation,"w");
	fwrite($file,$SVGData);
	fclose($file);
	//file_put_contents($fileLocation, $SVGData);
	
	$rtn ='<img style="width:95%; height:95%" src="http://thepurplepeople.co.uk/charts/'.$name.'pie.svg">';
	return $rtn;*/
}



if($name==''){
	$rtn='<div onclick="hideAlert()" id="alertMessage"><div>The Username or Password is incorrect</div><span>Click To Close [X]</span></div>'.signin();
}else{
	$rtn='<form id="search" name="search">'
		.'<input type="hidden" name="loginUser" id="loginUser" value="'.$loginUser.'"/>'
		.'<input type="hidden" name="loginPassword" id="loginPassword" value="'.$loginPassword.'"/>'
		.'<input type="hidden" name="userlat" id="userlat" value="'.$userlat.'"/>'
		.'<input type="hidden" name="userlon" id="userlon" value="'.$userlon.'"/>'
		.'<table class="dashTable" id="dashTable">'
		.'<tr class="titleRow">'
			.'<th colspan="3">Good day '.$name.'!</th>'
		.'</tr>'
		.'<tr>'
			.'<td class="container">'
				.'<div class="outerContainer">'
					.'<span>Weather</span>'
					.'<div class="innerContainer">'
					.weather($userlat,$userlon)
					.'</div>'
				.'</div>'
			.'</td>'
			.'<td class="container">'
				.'<div class="outerContainer">News'
					.'<div class="innerContainer">'
					.news()
					.'</div>'
				.'</div>'
			.'</td>'
			.'<td class="container">'
				.'<div class="outerContainer">Sport'
					.'<div class="innerContainer">'
					.sport()
					.'</div>'
				.'</div>'
			.'</td>'
		.'</tr>'
		.'<tr>'
			.'<td class="container">'	
				.'<div class="outerContainer">Photos'
					.'<div class="innerContainer">'
					.photos()
					.'</div>'
				.'</div>'
			.'</td>'
			.'<td class="container">'
				.'<div class="outerContainer">'
					.'<div onclick="loadTasks()">Tasks</div>'
					.'<div id="tasksContainer" class="innerContainer">'
					.tasks($name)
					.'</div>'
				.'</div>'
			.'</td>'
			.'<td class="container">'
				.'<div class="outerContainer">Clothes'
					.'<div id="clothesContainer" class="innerContainer">'
					//.clothes($name)
					.'</div>'
				.'</div>'
			.'</td>'
		.'</tr>'
		.'<tr>'
			.'<td colspan="3">'
			.'</td>'
		.'</tr>'
		.'<tr>'
			.'<td  colspan="3">'
				.''
			.'</td>'
		.'</tr>'
		.'</table>'
	.'</form>';
}
echo $rtn;

?>