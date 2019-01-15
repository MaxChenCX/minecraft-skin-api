<?php
ini_set('display_errors', false);
$userName = $_GET['name'];
$userUuid = $_GET['uuid'];
try{
	if(!empty($userUuid)){
		$uuid = $userUuid;
	}
	else if(!empty($userName)){
		$uuidStr = file_get_contents('https://api.mojang.com/users/profiles/minecraft/' . $userName);
		$uuidObj = json_decode($uuidStr, true);
		$uuid = $uuidObj['id'];	
	}
	else{
		echo 'parameter is empty.';
		exit();
	}
	sleep(0.5);
	$profileStr = file_get_contents('https://sessionserver.mojang.com/session/minecraft/profile/' . $uuid);
	$profileObj = json_decode($profileStr, true);
	$skinInfo = base64_decode($profileObj['properties'][0]['value']);
	$skinObj = json_decode($skinInfo, true);
	$skinUrl = $skinObj['textures']['SKIN']['url'];
	sleep(0.5);
	header("Content-type: image/png"); 
	echo file_get_contents($skinUrl);
	
}
catch(Exception $e){
	echo $e->getMessage();
}
?>