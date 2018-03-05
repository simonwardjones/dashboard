<?php
include('common.php');
include('home.php');
function signupContent(){
	$rtn='<form id="search" name="search">'
			.'<table class="signInTable" id="signInTable">'
			.'<tr class="titleRow">'
				.'<th colspan="3">Hackathon</th>'
			.'</tr>'
			.'<tr>'
				.'<td>'
					.'<span class="inputSpan">Username<input id="registerUser"/></span>'
				.'</td>'
				.'<td>'
				.'</td>'
				.'<td>'
					.'<span class="inputSpan">Email<input id="registerEmail"/></span>'
				.'</td>'
			.'</tr>'
			.'<tr>'
				.'<td>'
					.'<span class="inputSpan">Password<input id="registerPassword"/></span>'
				.'</td>'
				.'<td>'
				.'</td>'
				.'<td>'
					.'<span class="inputSpan">Confirm Password<input id="registerCPassword"/></span>'
				.'</td>'
			.'</tr>'
			.'<tr>'
				.'<td class="addPic" colspan="3">'
					.'<span></span>'
					.'<span >'
						.'Add picture'
					.'</span>'
					.'<span></span>'
				.'</td>'
			.'</tr>'
			.'<tr>'
				.'<td  colspan="3">'
					.'<div id="submitSignIn">'
						.'<img onclick="register();" src="http://thepurplepeople.co.uk/Assets/Register_Button.png">'
					.'</div>'
				.'</td>'
			.'</tr>'
			.'</table>'
		.'</form>';
	
	return $rtn;
}

function signup(){
	$users=[];
	$passwords=[];
	$emails=[];
	$errors=[];
	$registerUser=(isset($_GET['registerUser'])?$_GET['registerUser']:'');
	$registerEmail=(isset($_GET['registerEmail'])?$_GET['registerEmail']:'');
	$registerPassword=(isset($_GET['registerPassword'])?$_GET['registerPassword']:'');
	$registerCPassword=(isset($_GET['registerCPassword'])?$_GET['registerCPassword']:'');
	
	$rtn='';
	
	if($registerUser != '' && $registerEmail != '' && $registerPassword == $registerCPassword){
		$sql = "SELECT * FROM Ajax";
		$dbConn = openDb();
		$result = $dbConn->query($sql);
		
		while($row=$result->fetch_assoc()){
			$users[]=$row['name'];
			$emails[]=$row['email'];
		}
		if(in_array($registerUser,$users)){$errors[]='username '.$registerUser;}
		if(in_array($registerEmail,$emails)){$errors[]='email address '.$registerEmail;}
		
		if($errors!=[]){
			$rtn.='<div onclick="hideAlert()" id="alertMessage">'
					.'<div>An account with the '.implode(" and the ",$errors).' already exists!</div>'
					.'<span>Click To Close [X]</span>'
				.'</div>'.signupContent();
		}else{
			$sql = "INSERT INTO db709617157.Ajax (id, name, password, email) VALUES (NULL, '".$registerUser."', '".$registerPassword."', '".$registerEmail."')";
			$result = $dbConn->query($sql);
			$rtn.='<div onclick="hideAlert()" id="alertMessage"><div>You have set up an account for '.$registerUser.'!</div><span>Click To Close [X]</span></div>'.signin();
		}
	}else{
		$rtn.=signupContent();
	}
	echo $rtn;
}
signup();

?>