<?php
$surveyId = -1;
if(isset($_GET["surveyId"]) && !empty($_GET["surveyId"])){
    $thingId = $_GET["surveyId"];
}
$result = array();
require("common.inc.php");
?>
<?php
if(isset($_POST["updated"])){
    $title = "";
    $question = "";
    if(isset($_POST["title"]) && !empty($_POST["title"])){
        $name = $_POST["title"];
    }
    if(isset($_POST["question"]) && !empty($_POST["question"])){
        if(is_numeric($_POST["question"])){
            $quantity = (int)$_POST["question"];
        }
    
    if(!empty($title)){
        try{
            $query = NULL;
           echo "[question" . $question . "]";
            $query = file_get_contents(__DIR__ . "/queries/UPDATE_TABLE_SURVEY.sql");
            if(isset($query) && !empty($query)) {
                $stmt = getDB()->prepare($query);
                $result = $stmt->execute(array(
                    ":title" => $title,
                    ":question" => $question,
                    ":SurveyID" => $surveyId
                ));
                $e = $stmt->errorInfo();
                if ($e[0] != "00000") {
                    echo var_export($e, true);
                } else {
                    if ($result) {
                        echo "Successfully updated thing: " . $title;
                    } else {
                        echo "Error updating record";
                    }
                }
            }
            else{
                echo "Failed to find UPDATE_TABLE_SURVEY.sql file";
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "title must not be empty.";
    }
}
?>

<?php
//moved the content down here so it pulls the update from the table without having to refresh the page or redirect
//now my success message appears above the form so I'd have to further restructure my code to get the desired output/layout
if($surveyId > -1){
    $query = file_get_contents(__DIR__ . "/queries/SELECT_ONE_TABLE_SURVEY.sql");
    if(isset($query) && !empty($query)) {
        //Note: SQL File contains a "LIMIT 1" although it's not necessary since ID should be unique (i.e., one record)
        try {
            $stmt = getDB()->prepare($query);
            $stmt->execute([":SurveyID" => $surveyId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Failed to find SELECT_ONE_TABLE_SURVEY.sql file";
    }
}
else{
    echo "No surveyId provided in url, don't forget this or sample won't work.";
}
?>
<script src="js/script.js"></script>
<!-- note although <script> tag "can" be self terminating some browsers require the
full closing tag-->
<form method="POST"onsubmit="return validate(this);">
<label for="survey">Survey Name
    <!-- since the last assignment we added a required attribute to the form elements-->
    <input type="text" id="survey" name="title" value="<?php echo get($result, "title");?>" required />
</label>
<input type="submit" name="updated" value="Update Survey"/>
</form>