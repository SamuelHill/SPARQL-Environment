<?php
    require("common.php");
    if(empty($_SESSION['user'])) {
        header("Location: login.php");
        die("Redirecting to login.php");
    }

    if(!empty($_POST)) {
        if(empty($_POST['name'])) {
            die("Please enter a name.");
        }
        if(empty($_POST['desc'])) {
            die("Please enter a description.");
        }
        if(empty($_POST['source'])) {
            die("Please enter a source.");
        }

        // ADD DATASET INFO
        $query = "INSERT INTO dataset (name, description, source, prefix_list, variable_list)
                  VALUES (:name, :description, :source, :prefix_list, :variable_list)";
        $query_params = array(
            ':name' => $_POST['name'],
            ':description' => $_POST['desc'],
            ':source' => $_POST['source'],
            ':prefix_list' => $_POST['prefix'],
            ':variable_list' => $_POST['variable']
        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch(PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        // ADD CURRENT USER TO THE PERMISSIONS TABLE
        $query = "SELECT * FROM dataset WHERE name = :name AND source = :source";
        $query_params = array(
            ':name' => $_POST['name'],
            ':source' => $_POST['source']
        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch(PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $query = "INSERT INTO datapermission (data_id, user_id)
                  VALUES (:data_id, :user_id)";
        $query_params = array(
            ':data_id' => $row['id'],
            ':user_id' => $_SESSION['user']['username']
        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch(PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        header("Location: homepage.php");
        die("Redirecting to homepage.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Create Dataset</title>
	<link rel="stylesheet" type="text/css" href="webroot/css/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="webroot/css/bootstrap-adjust.css"/>
	<script type="text/javascript" src="webroot/js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="webroot/js/bootstrap.js"></script>
</head>
<!-- nav -->
<nav class="navbar navbar-default navbar-fixed-top">
<div class="container">
  <div class="navbar-header">
    <a class="navbar-brand" href="homepage.php">SPARQL-Environment</a>
    <p class="navbar-text">Signed in as
      <b><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></b>
    </p>
  </div>
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav navbar-right">
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="edit_user.php">Edit Account</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </li>
    </ul>
  </div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>
<body>
	<div id="main-container">
	<div id="content" class="container">
	<div id="page-container" class="row">
	<div id="page-content" class="col-sm-12">
    <h1 style="text-align: center;">Create Dataset</h1>
	  <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6">
        <form action="new_dataset.php" method="post" name="new_dataset_form" id="new_dataset_form">
          <fieldset>
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" name="name" class="form-control" id="name">
            </div>
            <div class="form-group">
              <label for="desc">Description:</label>
              <textarea name="desc" class="form-control" rows="3" id="desc"></textarea>
            </div>
            <div class="form-group">
              <label for="source">Source:</label>
              <input type="text" name="source" class="form-control" id="source">
            </div>
            <div class="form-group">
              <label for="prefix">Prefix List:</label>
              <textarea name="prefix" class="form-control" rows="3" id="prefix"></textarea>
            </div>
            <div class="form-group">
              <label for="variable">Variable List:</label>
              <textarea name="variable" class="form-control" rows="3" id="variable"></textarea>
            </div>
            <div class="row">
              <div class="col-xs-3"></div>
              <div class="col-xs-6">
                <input type="submit" name="create" class="form-control btn btn-primary" value="Create">
              </div>
              <div class="col-xs-3"></div>
            </div>
    			</fieldset>
        </form>
      </div>
      <div class="col-sm-3"></div>
    </div>
	</div>
	</div>
	</div>
	</div>
	</div>
</body>
</html>
