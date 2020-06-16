<?php
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$surveyId = -1;
$result = array();
function get($arr, $key){
    if(isset($arr[$key])){
        return $arr[$key];
    }
    return "";
}
if(isset($_GET["surveyId"])){
    $thingId = $_GET["surveyId"];
    $stmt = $db->prepare("SELECT * FROM Survey where id = :id");
    $stmt->execute([":id"=>$surveyId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$result){
        $surveyId = -1;
    }
}
else{
    echo "No surveyId provided in url, don't forget this or sample won't work.";
}
?>

<form method="POST">
	<label for="survey">Survey Name
	<input type="text" id="survey" name="name" value="<?php echo get($result, "name");?>" />
	</label>
	<label for="q">Survey Number
	<input type="number" id="n" name="sn" value="<?php echo get($result, "sn");?>" />
	</label>
    <?php if($surveyId > 0):?>
	    <input type="submit" name="updated" value="Update Survey"/>
    <?php elseif ($surveyId < 0):?>
        <input type="submit" name="created" value="Create Survey"/>
    <?php endif;?>
</form>

<?php
if(isset($_POST["updated"]) || isset($_POST["created"])){
    $name = $_POST["name"];
    $sn = $_POST["sn"];
    if(!empty($name) && !empty($sn)){
        try{
            if($surveyId > 0) {
                $stmt = $db->prepare("UPDATE Survey set name = :name, sn=:sn where id=:id");
                $result = $stmt->execute(array(
                    ":name" => $name,
                    ":sn" => $sn,
                    ":id" => $surveyId
                ));
            }
            else{
                $stmt = $db->prepare("INSERT INTO Survey (name, sn) VALUES (:name, :sn)");
                $result = $stmt->execute(array(
                    ":name" => $name,
                    ":sn" => $sn
                ));
            }
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully inserted or updated survey: " . $name;
                }
                else{
                    echo "Error inserting or updating record";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Name and title must not be empty.";
    }
}
?>