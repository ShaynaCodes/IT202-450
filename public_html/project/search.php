<?php
$search = "";
if(isset($_POST["search"])){
    $search = $_POST["search"];
}
?>
<form method="POST">
    <input type="text" name="search" placeholder="Search for question"
    value="<?php echo $search;?>"/>
    <input type="submit" value="Search"/>
</form>
<?php
if(isset($search)) {

    require("common.inc.php");
   /$query = file_get_contents(__DIR__ . "/sql/queries/SEARCH_TABLE_QUESTION.sql");
    if (isset($query) && !empty($query)) {
        try {
            $stmt = getDB()->prepare($query);
            //Note: With a LIKE query, we must pass the % during the mapping
            $stmt->execute([":question"=>$search]);
            //Note the fetchAll(), we need to use it over fetch() if we expect >1 record
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
	$response = DBH::get_available_surveys();
$available = [];
if(Common::get($response, "status", 400) == 200){
    $available = Common::get($response, "data", []);
}

}
?>
<!--This part will introduce us to PHP templating,
note the structure and the ":" -->
<!-- note how we must close each check we're doing as well-->
<div class="container-fluid">
    <h4>Surveys</h4>
    <div class="list-group">
        <?php foreach($available as $s): ?>
            <div class="list-group-item">
                <h6><?php echo Common::get($s, "name", ""); ?></h6>
                <p><?php echo Common::get($s, "description", ""); ?></p>
                <?php if(Common::get($s, "use_max", false)): ?>
                    <div>Max Attempts: <?php echo Common::get($s, "max_attempts", 0);?></div>
                <?php else:?>
                    <div>Daily Attempts: <?php echo Common::get($s, "attempts_per_day", 0);?></div>
                <?php endif; ?>
                <?php if(Common::get($s, "available", 0) == 1):?>
                <a href="survey.php?s=<?php echo Common::get($s, 'id', -1);?>" class="btn btn-secondary">Participate</a>
                <?php endif;?>
                <a href="results.php?survey_id=<?php echo Common::get($s, 'id', -1);?>" class="btn btn-secondary">Results</a>
            </div>
        <?php endforeach; ?>
        <?php if(count($available) == 0):?>
            <div class="list-group-item">
                No surveys available, please check back later.
            </div>
        <?php endif; ?>
    </div>
</div>