<?php
/*require("config.php");
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
    $surveyId = $_GET["surveyId"];
    $stmt = $db->prepare("SELECT * FROM Users where id = :id");
    $stmt->execute([":id"=>$surveyId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
}
else{
    echo "No surveyId provided in url, don't forget this or sample won't work.";
}*/
?>

<form method="POST">
	<label for="email">Email:
	<input type="email" id="email" name="email" value="<?php echo get($result, "email");?>" />
	</label>
	<label for="password">Password:
	<input type="password" id="password" name="password" value="<?php echo get($result, "password");?>" />
	</label>
	<input type="submit" name="updated" value="Update Users"/>
</form>

<?php
if (Common::get($_POST, "submit", false)){
    $email = Common::get($_POST, "email", false);
    $password = Common::get($_POST, "password", false);
    if(!empty($email) && !empty($password)){
        $result = DBH::update($email, $password);
        echo var_export($result, true);
        if(Common::get($result, "status", 400) == 200){
            //Note to self: Intentionally didn't add tank creation here
            //keeping it in login where it is (creates a new tank only if user has no tanks)
            //it fulfills the purpose there
            Common::flash("Successfully registered, please login", "success");
            $data = Common::get($result, "data", []);
            $id = Common::get($data,"user_id", -1);
            if($id > -1) {
                $result = DBH::check_survey_status($id, 10, -1, "earned", "Welcome");
                if(Common::get($result, "status", 400) == 200){
                    Common::flash("You can now create and participate in Surveys!", "success");
                }
            }
            die(header("Location: " . Common::url_for("login")));
        }
    }
    else{
        Common::flash("Email and password must not be empty", "warning");
        die(header("Location: register.php"));
    }
}