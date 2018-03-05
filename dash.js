function createUser(){
	if (window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("container").innerHTML = xmlhttp.responseText;
		}
	}
	
	xmlhttp.open('GET', 'dash.php?loginUser='+document.getElementById('loginUser').value , true);
	xmlhttp.send();
}
function login(){
	if (window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById("container").innerHTML = xmlhttp.responseText;
		}
	}
	
	xmlhttp.open('GET', 'dash.php?loginUser='+document.getElementById('loginUser').value , true);
	xmlhttp.send();
	
	loadClothes();
}

function loadClothes(){
	if (window.XMLHttpRequest){
		xmlhttp2 = new XMLHttpRequest();
	}else {
		xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp2.onreadystatechange = function(){
		if(xmlhttp2.readyState==4 && xmlhttp2.status==200){
			document.getElementById('clothesContainer').innerHTML = xmlhttp2.responseText;
		}
	}
	xmlhttp2.open('GET', 'loadClothes.php?loginUser='+document.getElementById('loginUser').value, true);
	xmlhttp2.send();	
}

function load(containerId,file){
	if (window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById(containerId).innerHTML = xmlhttp.responseText;
		}
	}
	
	xmlhttp.open('GET', file, true);
	xmlhttp.send();
}
function register(){
	if (window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('container').innerHTML = xmlhttp.responseText;
		}
	}
	
	xmlhttp.open('GET', 'signup.php?registerUser='+document.getElementById('registerUser').value + '&registerEmail=' + document.getElementById('registerEmail').value + '&registerPassword=' + document.getElementById('registerPassword').value + '&registerCPassword=' + document.getElementById('registerCPassword').value, true);
	xmlhttp.send();	
}
function hideAlert(){
	alertMessage=document.getElementById('alertMessage');
	alertMessage.parentElement.removeChild(alertMessage);
	
}

//unavailable without secure connection
function getLocation() { console.log('getLocation() unavailable without secure connection');}
/*
function getLocation() {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } 
}
function showPosition(position) {
    document.getElementById('userlat').value = position.coords.latitude;
    document.getElementById('userlon').value = position.coords.longitude;
}
*/

function toggleTask(taskid){
	if (window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('container').innerHTML = xmlhttp.responseText;
		}
	}
	if(document.getElementById('tickContainer'+taskid).innerHTML==''){
		ticked='';
	}else{
		ticked=document.getElementById('tickContainer'+taskid).innerHTML;
	}
	
	xmlhttp.open('GET', 'tickTask.php?loginUser=' + document.getElementById('loginUser').value + '&taskid='+taskid+'&ticked='+ticked, true);
	xmlhttp.send();	
}

function loadTasks(taskid){
	if (window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('container').innerHTML = xmlhttp.responseText;
		}
	}
		
	xmlhttp.open('GET', 'taskPage.php?loginUser='+document.getElementById('loginUser').value , true);
	xmlhttp.send();	
}

function getInputs(){
	allInputs=[];
	var x = document.getElementsByTagName("input");
	for(i=0;i<x.length;i++){
		allInputs[x[i].id]
		console.log(x[i].id);
	}
}

function updateTask(taskid){
	if (window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('container').innerHTML = xmlhttp.responseText;
		}
	}
		
	xmlhttp.open('GET', 'updateTask.php?' + 'loginUser=' + document.getElementById('loginUser').value + '&taskDescription=' + document.getElementById('taskDescription' + taskid).value + '&taskid=' + taskid, true);
	xmlhttp.send();	
}

function addTask(){
	if (window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState==4 && xmlhttp.status==200){
			document.getElementById('container').innerHTML = xmlhttp.responseText;
		}
	}
	
	xmlhttp.open('GET', 'addTask.php?' + 'loginUser=' + document.getElementById('loginUser').value , true);
	xmlhttp.send();	
}



















