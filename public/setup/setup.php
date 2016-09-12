<?php
	function run_sql($filename, $connection) {
		$file_content = file($filename);
		$query = "";
		foreach($file_content as $sql_line) {
			if(trim($sql_line) != "" && strpos($sql_line, "--") === false) {
				$query .= $sql_line;
				if (substr(rtrim($query), -1) == ';'){
					echo $query;
					$result = mysqli_query($connection, $query);
					$query = "";
				}
			}
		}
	}
	function run_json_mongo($filename, $collection, $dif) {
		$file_content = file_get_contents($filename);
		$json_Array = json_decode($file_content, true);
		foreach ($json_Array as $key => $value) {
			if ($dif == "hist") {
					$document = history_Array($value);
			} elseif ($dif == "plug") {
					$document = plugin_Array($value);
			} elseif ($dif == "conf") {
					$document = config_Array($value);
			}
			$collection->insert($document);
		}
	}
	function history_Array($value) {
		$document = array(
			"_id" => new MongoId($value['_id']),
			"view" => $value['view'],
			"user" => $value['user'],
			"history" => $value['history']
		);
		return $document;
	}
	function plugin_Array($value) {
		$document = array(
			"_id" => new MongoId($value['_id']),
			"view" => $value['view'],
			"user" => $value['user'],
			"plugins" => $value['plugins']
		);
		return $document;
	}
	function config_Array($value) {
		$document = array(
			"_id" => new MongoId($value['_id']),
			"config" => $value['config'],
			"urn" => $value['urn']
			);
		return $document;
	}

	// $linkID = mysqli_connect("localhost","root","root");
	$connection = mysqli_connect("localhost","root","root");
	if (!$connection) {
	    die("Database connection failed: " . mysqli_error());
	}
	//mysqli_select_db("scotchbox", $linkID) or die(mysqli_error());
	$db_select = mysqli_select_db($connection, "scotchbox");
	if (!$db_select) {
	    die("Database selection failed: " . mysqli_error());
	}
	$m = new MongoClient();
	$dbMongo = $m->scotchbox;
	$plugin_conf = $dbMongo->plugin_conf_doc;
	$plugins = $dbMongo->plugins_doc;
	$history = $dbMongo->history_doc;

	if($_POST['build'] == "schema + data"){
		run_sql("/var/www/public/setup/schema.sql", $connection);
		run_sql("/var/www/public/setup/data.sql", $connection);
		run_json_mongo("/var/www/public/setup/history_data.json", $history, "hist");
		run_json_mongo("/var/www/public/setup/plugins_data.json", $plugins, "plug");
		run_json_mongo("/var/www/public/setup/plugin_conf_data.json", $plugin_conf, "conf");
	} else {
		run_sql("/var/www/public/setup/schema.sql", $connection);
	}

	header("Location: /login.php");
	die("Redirecting to login.php");
?>
