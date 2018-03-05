<?php
	$loginUser=$_GET['loginUser'];
	$name=$loginUser;
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
	
	$fileLocation = getenv("DOCUMENT_ROOT") . "/dash/charts/".$name."pie.svg";
	$file = fopen($fileLocation,"w");
	fwrite($file,$SVGData);
	fclose($file);
	//file_put_contents($fileLocation, $SVGData);
	
	$rtn ='<img style="width:95%; height:95%" src="http://thepurplepeople.co.uk/dash/charts/'.$name.'pie.svg">';
	echo $rtn;

 ?>