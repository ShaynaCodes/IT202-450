<?php
include_once(__DIR__."/partials/header.partial.php");
?>
    <div>
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
if(isset($_POST["login"])){
	if(isset($_POST["password"]) && isset($_POST["email"])){
		$password = $_POST["password"];
		$email = $_POST["email"];
		require("config.php");
			$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
			try{
				$db = new PDO($connection_string, $dbuser, $dbpass);
				$stmt = $db->prepare("SELECT * FROM Users where email = :email LIMIT 1");
				$stmt->execute(array(
					":email" => $email
				));
				$e = $stmt->errorInfo();
				if($e[0] != "00000"){
					echo var_export($e, true);
				}
				else{
					$result = $stmt->fetch(PDO::FETCH_ASSOC);
					if ($result){
						$rpassword = $result["password"];
						if(password_verify($password, $rpassword)){
							echo "<div>Passwords matched! You are technically logged in!</div>";
							$_SESSION["user"] = array(
								"id"=>$result["id"],
								"email"=>$result["email"],
							);
							echo var_export($_SESSION, true);
							echo "<a href='surveys.php'>Go to surveys page</a>";
						}
						else{
							echo "<div>Invalid password!</div>";
						}
					}
					else{
						echo "<div>Invalid user</div>";
					}
					//echo "<div>Successfully registered!</div>";
				}
			}
			catch (Exception $e){
				echo $e->getMessage();
			}
	}
}
?>