<?php
$id = -1;
if(isset($_GET["id"]) && !empty($_GET["id"])){
    $id = $_GET["id"];
}
$result = array();
require("common.inc.php");
?>
<?php
if(isset($_POST["updated"])){
    $email = "";
    $first_name = "";
    if(isset($_POST["emial"]) && !empty($_POST["email"])){
        $email = $_POST["email"];
    }
    if(isset($_POST["first_name"]) && !empty($_POST["first_name"])){
        $first_name = $_POST["first_name"];
    }
    if(!empty($email) && !empty($first_name){
        try{
            $query = NULL;
            echo "[first_name" . $first_name . "]";
            $query = file_get_contents(__DIR__ . "/queries/UPDATE_TABLE_THINGS.sql");
            if(isset($query) && !empty($query)) {
                $stmt = getDB()->prepare($query);
                $result = $stmt->execute(array(
                    ":email" => $email,
                    ":first_name" => $first_name,
                    ":id" => $id
                ));
                $e = $stmt->errorInfo();
                if ($e[0] != "00000") {
                    echo var_export($e, true);
                } else {
                    if ($result) {
                        echo "Successfully updated User: " . $email;
                    } else {
                        echo "Error updating record";
                    }
                }
            }
            else{
                echo "Failed to find UPDATE_TABLE_THINGS.sql file";
            }
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Email and First Name must not be empty.";
    }
}
?>

<?php
//moved the content down here so it pulls the update from the table without having to refresh the page or redirect
//now my success message appears above the form so I'd have to further restructure my code to get the desired output/layout
if($id > -1){
    $query = file_get_contents(__DIR__ . "/queries/SELECT_ONE_TABLE_THINGS.sql");
    if(isset($query) && !empty($query)) {
        //Note: SQL File contains a "LIMIT 1" although it's not necessary since ID should be unique (i.e., one record)
        try {
            $stmt = getDB()->prepare($query);
            $stmt->execute([":id" => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
    else{
        echo "Failed to find SELECT_ONE_TABLE_THINGS.sql file";
    }
}
else{
    echo "No id provided in url, don't forget this or sample won't work.";
}
?>
<script src="js/script.js"></script>
<!-- note although <script> tag "can" be self terminating some browsers require the
full closing tag-->
<form method="POST"onsubmit="return validate(this);">
<label for="thing">Email:
    <!-- since the last assignment we added a required attribute to the form elements-->
    <input type="email" id="email" name="email" value="<?php echo get($result, "email");?>" required />
</label>
<label for="q">First Name:
    <!-- We also added a minimum value for our number field-->
    <input type="FN" id="FN" name="FN" value="<?php echo get($result, "first_name");?>" required min="0"/>
</label>
<input type="submit" name="updated" value="Update Users"/>
</form>