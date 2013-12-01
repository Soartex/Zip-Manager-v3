<?php 
session_start();
if(isset($_POST['submit'])){
	// Get data
	$string = file_get_contents("../data/options.json");
	$json = json_decode($string, true);
	// Update Session from json
	$_SESSION['Config_Path']=$json[$_POST['preset']]["Config_Path"];
	$_SESSION['Zip_Path']="../../".$json[$_POST['preset']]["Zip_Path"];
	//redirect
	header("Location: ../browse/");
	exit;
}
else{
    header("Location: ./");     
    exit; 
} 
?>