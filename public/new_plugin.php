<?php
    require("common.php");
    if(empty($_SESSION['user'])) {
        header("Location: login.php");
        die("Redirecting to login.php");
    }

    if(!empty($_POST)) {
        if(empty($_POST['urn'])) {
            die("Please enter a URN.");
        }
        if(empty($_POST['name'])) {
            die("Please enter a name.");
        }
        if(empty($_POST['desc'])) {
            die("Please enter a description.");
        }

        // SAVE CONFIG DOCUMENT
        $m = new MongoClient();
        $dbMongo = $m->scotchbox;
        $collection = $dbMongo->plugin_conf_doc;
        $document = array(
              "config" => $_POST['config'],
              "urn" => $_POST['urn']);
        $collection->insert($document);
        $config = $collection->findOne(array("urn" => $_POST['urn']));

        // ADD PLUGIN INFO
        $query = "INSERT INTO plugin (urn, name, description, config_doc_id, owner)
                  VALUES (:urn, :name, :description, :config_id, :owner)";
        $query_params = array(
            ':urn' => $_POST['urn'],
            ':name' => $_POST['name'],
            ':description' => $_POST['desc'],
            ':owner' => $_SESSION['user']['username'],
            ':config_id' => $config['_id']
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
	<title>Create Plugin</title>
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
    <h1 style="text-align: center;">Create Plugin</h1>
	  <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6">
        <form action="new_plugin.php" method="post" name="new_plugin_form" id="new_plugin_form">
          <fieldset>
            <div class="form-group">
              <label for="urn">URN:</label>
              <input type="text" name="urn" class="form-control" id="urn">
            </div>
            <div class="form-group">
              <label for="name">Name:</label>
              <input type="text" name="name" class="form-control" id="name">
            </div>
            <div class="form-group">
              <label for="desc">Description:</label>
              <textarea name="desc" class="form-control" rows="3" id="desc"></textarea>
            </div>
            <div class="form-group">
              <label for="config">Config:</label>
              <textarea name="config" class="form-control" rows="6" id="config"></textarea>
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
