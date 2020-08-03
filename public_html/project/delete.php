<?php
if (isset($_GET["id"]) && !empty($_GET["id"])){
    if(is_numeric($_GET["id"])){
        $id = (int)$_GET["id"];
        $query = file_get_contents(__DIR__ . "/sql/queries/DELETE_ONE_TABLE_QUESTION.sql");
        if(isset($query) && !empty($query)) {
            require("common.inc.php");
            $stmt = getDB()->prepare($query);
            $stmt->execute([":id"=>$id]);
            $e = $stmt->errorInfo();
            if($e[0] == "00000"){
                //we're just going to redirect back to the list
                //it'll reflect the delete on reload
                //also wrap it in a die() to prevent the script from any continued execution
                die(header("Location: surveys.php"));
            }
            else{
                echo var_export($e, true);
            }
        }
    }
}
else{
    echo "Invalid thing to delete";
}