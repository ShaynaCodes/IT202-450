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
<h3><center><font size="24" color="#581845">Register</font></center></h3>
<div>
<form method = "POST">
	<label for="email">Email:<br>
	<input type="email" id="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="Must Enter an Email"  required><br>
	</label>
	<label for="p">Password:<br>
	<input type="password" id="p" name="password" title="Must Enter a password" required><br>
	</label>
	<label for = "cp">Confirm Password:<br>
	<input type="password" id="cp" name="cpassword" title="Must Enter a password" required><br>
	</label>
	<input type ="submit" name="register" value="Register"/> 
</form>
</div>
<?php
if(isset($_POST["register"])){
if(isset($_POST["password"]) && isset($_POST["cpassword"]) && isset($_POST["email"])){
		$password = $_POST["password"];
		$cpassword = $_POST["cpassword"];
		$email = $_POST["email"];
		if($password == $cpassword){
			//echo "<div>Password Match</div>";
			require("config.php");
			$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
			try{
				$db = new PDO($connection_string, $dbuser, $dbpass);
				$hash = password_hash($password, PASSWORD_BCRYPT);
				$stmt = $db->prepare("INSERT INTO Users (email, password) VALUES(:email, :password)");
				$stmt->execute(array(
					":email" => $email,
					":password" => $hash 
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