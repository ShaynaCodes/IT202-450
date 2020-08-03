<?php
include_once(__DIR__."/partials/header.partial.php");
?>
<?php
$surveyId = -1;
if(isset($_GET["surveyId"]) && !empty($_GET["surveyId"])){
    $surveyId = $_GET["surveyId"];
}
$result = array();
require("common.inc.php");
?>
<?php
if(isset($_POST["submit"])){
    $name = "";
    $password = "";
    if(isset($_POST["email"]) && !empty($_POST["email"])){
        $email = $_POST["email"];
    }
     if(isset($_POST["password"]) && !empty($_POST["password"])){
        $password = $_POST["password"];
    }
    if(!empty($email) && !empty($password)){
        try{
            $query = NULL;
            echo "[password" . $password . "]";
            $query = file_get_contents(__DIR__ . "/sql/queries/update.sql");
            if(isset($query) && !empty($query)) {
                $stmt = getDB()->prepare($query);
                $result = $stmt->execute(array(
                    ":email" => $email,
                    ":password" => $password,
                    ":id" => $surveyId
                ));
                $e = $stmt->errorInfo();
                if ($e[0] != "00000") {
                    echo var_export($e, true);
                } else {
                    if ($result) {
                        echo "Successfully updated user: " . $email;
                    } else {
                        echo "Error updating record";
                    }
                }
            }
            else{
                echo "Failed to find update.sql file";
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
<?php
//moved the content down here so it pulls the update from the table without having to refresh the page or redirect
//now my success message appears above the form so I'd have to further restructure my code to get the desired output/layout
if($surveyId > -1){
    $query = file_get_contents(__DIR__ . "/sql/queries/SELECT_ONE_TABLE_USERS.sql");
    if(isset($query) && !empty($query)) {
        //Note: SQL File contains a "LIMIT 1" although it's not necessary since ID should be unique (i.e., one record)
        try {
            $stmt = getDB()->prepare($query);
            $stmt->execute([":id" => $surveyId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Failed to find SELECT_ONE_TABLE_USERS.sql file";
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
<label for="email">Email:
    <!-- since the last assignment we added a required attribute to the form elements-->
    <input type="email" id="email" name="email" value="<?php echo get($result, "email");?>"/>
</label>
<label for="password">Password:
    <!-- We also added a minimum value for our number field-->
    <input type="password" id="password" name="password" value="<?php echo get($result, "password");?>"/>
</label>
<input type="submit" name="updated" value="Update Users"/>
</form>
<?php
/*
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
}*/
?>