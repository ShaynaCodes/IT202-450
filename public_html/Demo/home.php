<?php
include("header.php");

?>
<h3><center><font size="24" color="#581845">Home</font></center></h3>
<?php
session_start();

echo "Welcome to my homepage, " . $_SESSION["user"]["email"];
?>
