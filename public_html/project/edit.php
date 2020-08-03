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
    $stmt = $db->prepare("SELECT * FROM Users where id = :id");
    $stmt->execute([":id"=>$surveyId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
else{
    echo "No surveyId provided in url, don't forget this or sample won't work.";
}
?>

<form method="POST">
	<label for="survey">Email:
	<input type="email" id="email" name="email" value="<?php echo get($result, "email");?>" />
	</label>
	<label for="q">Password
	<input type="password" id="password" name="password" value="<?php echo get($result, "password");?>" />
	</label>
	<input type="submit" name="updated" value="Update Survey"/>
</form>

<?php
if(isset($_POST["updated"])){
    $email = $_POST["email"];
    $password = $_POST["password"];
    if(!empty($email) && !empty($password)){
        try{
            $stmt = $db->prepare("UPDATE Users set email = :email, password=:password where id=:id");
            $result = $stmt->execute(array(
                ":email" => $email,
                ":password" => $password,
                ":id" => $surveyId
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully updated users: " . $email;
                }
                else{
                    echo "Error updating record";
                }
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "email and password must not be empty.";
    }
}
?>