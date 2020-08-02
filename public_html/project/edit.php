<?php
require("config.php");
$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
$db = new PDO($connection_string, $dbuser, $dbpass);
$id = -1;
$result = array();
function get($arr, $key){
    if(isset($arr[$key])){
        return $arr[$key];
    }
    return "";
}
if(isset($_GET["id"])){
    $id = $_GET["id"];
    $stmt = $db->prepare("SELECT * FROM Users where id = :id");
    $stmt->execute([":id"=>$id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
else{
    echo "No id provided in url, don't forget this or sample won't work.";
}
?>

<form method="POST">
	<label for="email">Email:
	<input type="email" id="email" name="email" value="<?php echo get($result, "email");?>" />
	</label>
	<label for="q">Password:
	<input type="password" id="password" name="password" value="<?php echo get($result, "password");?>" />
	</label>
	<input type="submit" name="updated" value="Update Email/Password"/>
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
                ":id" => $id
            ));
            $e = $stmt->errorInfo();
            if($e[0] != "00000"){
                echo var_export($e, true);
            }
            else{
                echo var_export($result, true);
                if ($result){
                    echo "Successfully updated Users: " . $email;
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
        echo "Email and Password must not be empty.";
    }
}
?>