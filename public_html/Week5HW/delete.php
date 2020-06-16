<?php
require("common.inc.php");
$db = getDB();
//example usage, change/move as needed
$stmt = $db->prepare("SELECT * FROM Survey");
$stmt->execute();
?>