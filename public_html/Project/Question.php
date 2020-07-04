<?php
include("header.php");

?>
<h3><center><font size="24" color="#581845">Questions for Survey</font></center></h3>
<div>
<form method = "POST">
	<label for="Question">Write your Question:<br>
	<input type="question" id="question" name="question" ><br>
	</label>
	<label for=Answer1">Write your Answer 1:<br>
	<input type="answer1" id="answer1" name="answer1" ><br>
	</label>
	<label for=Answer2">Write your Answer 2:<br>
	<input type="answer2" id="answer2" name="answer2" ><br>
	</label>
	<label for=Answer3">Write your Answer 3:<br>
	<input type="answer3" id="answer3" name="answer3" ><br>
	</label>
	<label for=Answer4">Write your Answer 4:<br>
	<input type="answer4" id="answer4" name="answer4"  ><br>
	</label>
	<input type="submit" name="survey" value="Survey"/>
</form>
</div>
<?php
if(isset($_POST["survey"])){
	if(isset($_POST["question"]) && isset($_POST["answer1"]) && isset($_POST["answer2"])&& isset($_POST["answer3"])&& isset($_POST["answer3"])
		&& isset($_POST["answer4"])){
			$question = $_POST["question"];
			$Option1 = $_POST["answer1"];
			$Option2 = $_POST["answer2"];
			$Option3 = $_POST["answer3"];
			$Option4 = $_POST["answer4"];
		if(($Option1!=$Option2)&&($Option1!=$Option3)&&($Option1!=$Option4)&&($Option2!=$Option3)&&($Option2!=$Option4)&&($Option3!=$Option4)){
			require("config.php");
			$connection_string = "mysql:host=$dbhost;dbname=$dbdatabase;charset=utf8mb4";
			try{
				$db = new PDO($connection_string, $dbuser, $dbpass);
				$stmt = $db->prepare("INSERT INTO Survey (question) VALUES (:question)");
				$r = $stmt->execute(array(
					":question"=> $question
					//":answer1"=> $Option1
					//":answer2"=> $Qption2
					//":answer3"=> $Option3
					//":answer4"=> $Option4
				));
				echo var_export($stmt->errorInfo(), true);
				echo var_export($r, true);
			}
			catch (Exception $e){
				echo $e->getMessage();
			}
		}
		else{
			echo "<div>Answers Match! Change the anwsers</div>";
		}
	}
}
?>
