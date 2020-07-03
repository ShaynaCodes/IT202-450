<?php
require("config.php");

$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
try{
	$db = new PDO($connection_string, $dbuser, $dbpass);
	$stmt = $db->prepare("CREATE TABLE `Survey` (
				`SurveyID` int auto_increment not null,
				`question` text,
				`Option1` vaarchar(255),
				`Option2` vaarchar(255),
				`Option3` vaarchar(255),
				`Option4` vaarchar(255),
				`vote1` int (11),
				`vote2` int (11),
				`vote3` int (11),
				`vote4` int (11),
				PRIMARY KEY (`SurveyID`)
				) CHARACTER SET utf8 COLLATE utf8_general_ci");
	$r = $stmt->execute();
	echo var_export($stmt->errorInfo(), true);
	echo var_export($r, true);
}
catch (Exception $e){
	echo $e->getMessage();
}
?>