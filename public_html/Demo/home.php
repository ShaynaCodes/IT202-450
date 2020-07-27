<?php
include("header.php");
if(Common::is_logged_in()){
    //this will auto redirect if user isn't logged in
	
    Common::aggregate_stats_and_refresh();
    $questionnaires = [];
    $result = DBH::get_full_questionnaire(Common::get_user_id());
    if(Common::get($result, "status", 400) == 200){
        $questionnaires = Common::get($result, "data", []);
    }
}
?>
<h3><center><font size="24" color="#581845">Home</font></center></h3>
<?php
session_start();

echo "Welcome to my homepage, " . $_SESSION["user"]["email"];
?>
