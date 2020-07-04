<head>
  <link rel="stylesheet" href="style.css">
</head>
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
    $visibility = -1;
    if(isset($_POST["title"]) && !empty($_POST["title"])){
        $name = $_POST["title"];
    }
    if(isset($_POST["visibility"]) && !empty($_POST["visibility"])){
        if(is_numeric($_POST["visibility"])){
            $visibility = (int)$_POST["visibility"];
        }
    }
    if(!empty($title) && $visibility > -1){
        try{
            $query = NULL;
           echo "[visibility" . $visibility . "]";
            $query = file_get_contents(__DIR__ . "/queries/UPDATE_TABLE_SURVEY.sql");
            if(isset($query) && !empty($query)) {
                $stmt = getDB()->prepare($query);
                $result = $stmt->execute(array(
                    ":title" => $title,
                    ":visibility" => $visibility,
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
        echo "title and visibility must not be empty.";
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
<label for="v">Visibility
    <!-- We also added a minimum value for our number field-->
    <input type="number" id="v" name="visibility" value="<?php echo get($result, "visibility");?>" required min="0"/>
</label>
<input type="submit" name="updated" value="Update Survey"/>
</form>