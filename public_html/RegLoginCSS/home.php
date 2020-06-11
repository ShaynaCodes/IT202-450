<?php
include("header.php");

?>
<h3><center><font size="24" color="#581845">Home</font></center></h3>
<?php
echo "Welcome to my homepage, " . $_SESSION["user"]["email"];
?>
