<?php
include("header.php");
?>
<style>
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #581845;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #4B113A;
}

div {
  border-radius: 5px;
  background-color: #FFF0F5;
  padding: 20px;
}
</style>
<h3><center><font size="24" color="#581845">Login</font></center></h3>
<div>
<form method="POST">
	<label for="email">Email:<br>
	<input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Must Enter an Email" required><br>
	</label><br>
	<label for="p">Password: <br>
	<input type="password" id="p" name="password" autocomplete="off" title="Must Enter a password" required>
	</label><br>
	<input type="submit" name="login" value="Login"/>
</form>
</div>
<?php
if (Common::get($_POST, "submit", false)){
    $email = Common::get($_POST, "email", false);
    $password = Common::get($_POST, "password", false);
    if(!empty($email) && !empty($password)){
        $result = DBH::login($email, $password);
        echo var_export($result, true);
        if(Common::get($result, "status", 400) == 200){
            $_SESSION["user"] = Common::get($result, "data", NULL);

            //fetch system user id and put it in session to reduce DB calls to fetch it when we need
            //to generate points from activity on the app
            $result = DBH::get_system_user_id();
            $result = Common::get($result, "data", false);
            if($result) {
                $_SESSION["system_id"] = Common::get($result, "id", -1);
                error_log("Got system_id " . $_SESSION["system_id"]);
            }
            //end system user fetch
            //get user questionnaires(s) and store in session, not necessary but saves extra DB calls later
            $result = DBH::get_(Common::get_user_id());
            if(Common::get($result, "status", 400) == 200){
                $questionnaires = Common::get($result, "data", []);
                if(count($questionnaires) == 0) {
                    //this section is needed to give any previously existing users a questionnaires that didn't have a questionnaires before
                    //this feature was created/added
                    $result = DBH::create_tank(Common::get_user_id());
                    if (Common::get($result, "status", 400) == 200) {
                        $result = DBH::get_(Common::get_user_id());
                        if (Common::get($result, "status", 400) == 200) {
                            $questionnaires = Common::get($result, "data", []);
                        }
                    }
                }
                //finally let's save our  in session
                $_SESSION["user"]["questionnaires"] = $questionnaires;
            }
            //end get 

            die(header("Location: " . Common::url_for("surveys")));
        }
        else{
            Common::flash(Common::get($result, "message", "Error logging in"));
            die(header("Location: " . Common::url_for("login")));
        }
    }
    else{
        Common::flash("Email and password must not be empty", "warning");
        die(header("Location: " . Common::url_for("login")));
    }
}
?>