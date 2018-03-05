
<?php
	$weatherRequest = 'http:'.'//api.openweathermap.org/data/2.5/weather?units=metric&lat='.$userlat.'&lon='.$userlon.'&appid=d0a10211ea3d36b0a6423a104782130e';

	$weatherResponse  = file_get_contents($weatherRequest);
	$weatherJson  = json_decode($weatherResponse);
	
	if($weatherJson->weather[0]->id<800){
		$weatherId='rain';
		$weatherBg='http://thepurplepeople.co.uk/dash/Assets/Rain_icon.png';
	}else if($weatherJson->weather[0]->id==800 || $weatherJson->weather[0]->id==804){
		$weatherId='sun';
		$weatherBg='http://thepurplepeople.co.uk/dash/Assets/Sun_icon.png';
	}else{
		$weatherId='cloud';
		$weatherBg='http://thepurplepeople.co.uk/dash/Assets/Clouds_icon.png';
	}
	
	echo $weatherRequest;
	echo $weatherJson->weather[0]->id;
?>