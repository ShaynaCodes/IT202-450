<?php
$result = array("status"=>200, "message"=>"Nothing happened");
if (isset($_GET["question"]) && !empty($_GET["question"])){
    if(is_numeric($_GET["question"])){
        $question = (int)$_GET["question"];
        $query = file_get_contents(__DIR__ . "/queries/DELETE_ONE_TABLE_SURVEY.sql");
        if(isset($query) && !empty($query)) {
            require("common.inc.php");
            $stmt = getDB()->prepare($query);
            $stmt->execute([":question"=>$question]);
            $e = $stmt->errorInfo();
                if($e[0] == "00000"){
                    //we're just going to redirect back to the list
                    //it'll reflect the delete on reload
                    //also wrap it in a die() to prevent the script from any continued execution
                    $result["message"] = "Successfully deleted thing";
                }
                else{
                    $result["message"] = "Error deleting thing";
                    $result["error"] = var_export($e,true);
                    $result["status"] = 400;
            }
        }
    }
}
else{
    $result["message"] = "Invalid thing to delete";
    $result["status"] = 400;
}
echo json_encode($result);
?>