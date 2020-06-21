<?php
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$thingId = -1;
$result = array();
function get($arr, $key){
    if(isset($arr[$key])){
        return $arr[$key];
    }
    return "";
}
if(isset($_GET["thingId"])){
    $thingId = $_GET["thingId"];
    $stmt = $db->prepare("SELECT * FROM Surveys where id = :id");
    $stmt->execute([":id"=>$thingId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if(!$result){
        $thingId = -1;
    }
}
else{
    echo "No thingId provided in url, don't forget this or sample won't work.";
}
?>

<form method="POST">
	<label for="survey">Survey Name
	<input type="text" id="survey" name="name" value="<?php echo get($result, "name");?>" />
	</label>
	<label for="q">Quantity
	<input type="number" id="q" name="quantity" value="<?php echo get($result, "quantity");?>" />
	</label>
    <?php if($thingId > 0):?>
	    <input type="submit" name="updated" value="Update Survey"/>
        <input type="submit" name="delete" value="Delete Survey"/>
    <?php elseif ($thingId < 0):?>
        <input type="submit" name="created" value="Create Survey"/>
    <?php endif;?>
</form>

<?php
if(isset($_POST["updated"]) || isset($_POST["created"]) || isset($_POST["delete"])){
    $delete = isset($_POST["delete"]);
    $name = $_POST["name"];
    $quantity = $_POST["quantity"];
    if(!empty($name) && !empty($quantity)){
        try{
            if($thingId > 0) {
                if($delete){
                    $stmt = $db->prepare("DELETE from Surveys where id=:id");
                    $result = $stmt->execute(array(
                        ":id" => $thingId
                    ));
                }
                else {
                    $stmt = $db->prepare("UPDATE Surveys set name = :name, quantity=:quantity where id=:id");
                    $result = $stmt->execute(array(
                        ":name" => $name,
                        ":quantity" => $quantity,
                        ":id" => $thingId
                    ));
                }
            }
            else{
                $stmt = $db->prepare("INSERT INTO Surveys (name, quantity) VALUES (:name, :quantity)");
                $result = $stmt->execute(array(
                    ":name" => $name,
                    ":quantity" => $quantity
                ));
            }
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully interacted with survey: " . $name;
                }
                else{
                    echo "Error interacting record";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Name and quantity must not be empty.";
    }
}
?>