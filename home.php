<?php 
function signIn(){
$rtn='<form id="search" name="search">'
	.'<table class="signInTable" id="signInTable">'
		.'<tr class="titleRow">'
			.'<th  colspan="3"><div>Hackathon</div></th>'
		.'</tr>'
		.'<tr>'
			.'<td>'
				.'<span class="inputSpan">Username<input name="loginUser" id="loginUser" value="e"/></span>'
			.'</td>'
			.'<td>'
			.'</td>'
			.'<td>'
				.'<span class="inputSpan">Password<input name="loginPassword" id="loginPassword" value="e"/></span>'
			.'</td>'
		.'</tr>'
		.'<tr>'
			.'<td  colspan="3">'
				.'<div id="submitSignIn"><img onclick="login();" src="http://thepurplepeople.co.uk/Assets/Login_Button.png"></div>'
			.'</td>'
		.'</tr>'
		.'<tr>'
			.'<td  id="signUpCell" colspan="3">'
				.'<div >New to the Hackathon? <span onclick="load(\'container\',\'signup.php\');" id="signUpSpan">Sign up<span></div>'
			.'</td>'
		.'</tr>'
	.'</table>'
	.'<input type="hidden" name="userlat" id="userlat" value=""/>'
	.'<input type="hidden" name="userlon" id="userlon" value=""/>'
.'</form>';
return $rtn;
}
?>