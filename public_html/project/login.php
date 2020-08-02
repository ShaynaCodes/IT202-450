<?php
include_once(__DIR__."/partials/header.partial.php");
?>
    <div class="container-fluid">
        <h4>Login</h4>
        <form method="POST">
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required/>
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required min="3"/>
            </div>
            <input type="submit" name="submit" value="Login"/>
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
      
            $result = DBH::get_roles(Common::get_user_id());
            if(Common::get($result, "status", 400) == 200){
                $role = Common::get($result, "data", []);
                if($role = "admin") {
                 /* $result = DBH::create_questionnaire(Common::get_user_id());
                    if (Common::get($result, "status", 400) == 200) {
                        $result = DBH::get_roles(Common::get_user_id());
                        if (Common::get($result, "status", 400) == 200) {
                            $role = Common::get($result, "data", []);
                        }
					
                    }*/
               $_SESSION["user"]["role"] == "admin";
			   }
             
           //  $_SESSION["user"]["role"] == "admin";
            }
            //end get tanks
			$_SESSION["user"]["role"] == "admin";
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