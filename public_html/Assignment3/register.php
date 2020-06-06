<form method = "POST">
	<label for="email">Email
	<input type="email" id="email" name="email"/>
	</label>
	<label for="p">Password
	<input type="password" id="p" name="password" />
	</label>
	<label for = "cp">Confirm Password
	<input type="password" id="cp" name="cpassword"/>
	</label>
	<input type ="submit" name="register" value="Register"/> 
</form>

<?php
if(isset($_POST["register"])){
if(isset($_POST["password"]) && isset($_POST["cpassword"]) && isset($_POST["email"])){
		$password = $_POST["password"];
		$cpassword = $_POST["cpassword"];
		if($password == $cpassword){
			//echo "<div>Password Match</div>";
			require("config.php");
			$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
			try{
				$db = new PDO($connection_string, $dbuser, $dbpass);
				$stmt = $db->prepare("INSERT INTO Users (email, password) VALUES(:email, :password)");
				$stmt->execute(array(
					":email" => $email,
					":password" => $password
					));
					$e = $stmt->errorInfo();
					if($e[0] != "00000"){
						echo var_export($e, true);
					}
					else{
						echo "<div>Successfully registered!</div>";
					}
				}
			catch (Exception $e){
				echo $e->getMessage();
			}
		}
		else{
			echo "<div>Password Do Not Match</div>";
		}
	}
}
?>