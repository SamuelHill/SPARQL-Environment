<?php
    require("common.php");
    if(empty($_SESSION['user'])) {
        header("Location: login.php");
        die("Redirecting to login.php");
    }

    if(empty($_POST)) {
        // USERS CAN ONLY EDIT THEIR PLUGINS
        $query = "SELECT owner FROM plugin
                  WHERE plugin.urn = :urn";
        $query_params = array(':urn' => $_GET['urn']);
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch(PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $row = $stmt->fetch();
        if ($row['owner'] != $_SESSION['user']['username'] || empty($row)) {
            header("Location: homepage.php");
            die("Redirecting to homepage.php");
        }
    } else {
        // PREP MONGO...
        $m = new MongoClient();
        $dbMongo = $m->scotchbox;

        // Check name...
        if(empty($_POST['name'])) {
            die("Please enter a name.");
        }

        if(!empty($_POST['config'])) {
            // UPDATE PLUGIN CONFIG
            $collection_1 = $dbMongo->plugin_conf_doc;
            $document_1_search = array("urn" => $_GET['urn']);
            $document_1 = array('$set' => array("config" => $_POST['config']));
            $collection_1->update($document_1_search,$document_1);
        }

        // ADD PLUGIN INFO
        $query = "UPDATE plugin SET name = :name";
        $query_params = array(
            ':name' => $_POST['name'],
            ':urn' => $_POST['urn']
        );
        if(!empty($_POST['desc'])) {
            $query .= ", description = :description";
            $query_params[":description"] = $_POST['desc'];
        }
        $query .= " WHERE urn = :urn";
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
	<title>Edit View</title>
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
    <h1 style="text-align: center;">Edit View</h1>
	  <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6">
        <form action="edit_plugin.php" method="post" name="edit_plugin_form" id="edit_plugin_form">
          <fieldset>
            <?php // PREP MONGO...
              $m = new MongoClient();
              $dbMongo = $m->scotchbox;

              // GATHER INFO ABOUT THIS VIEW
              $query = "SELECT name, description FROM plugin
                        WHERE plugin.urn = :urn";
              $query_params = array(':urn' => $_GET['urn']);
              try {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
              } catch(PDOException $ex) {
                  die("Failed to run query: " . $ex->getMessage());
              }
              $row = $stmt->fetch();
              // UPDATE PLUGIN CONFIG
              $collection_0 = $dbMongo->plugin_conf_doc;
              $document_0 = array("urn" => $_GET['urn']);
              $config_0 = $collection_0->findOne($document_0);
              print('<div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" name="name" class="form-control" id="name" value="' . $row['name'] . '">
                    </div>
                    <div class="form-group">
                      <label for="desc">Description:</label>
                      <textarea name="desc" class="form-control" rows="3" id="desc">' . $row['description'] . '</textarea>
                    </div>
                    <div class="form-group">
                      <label for="plugins">Config:</label>
                      <textarea name="plugins" class="form-control" rows="6" id="plugins">' . $config_0['config'] . '</textarea>
                    </div>
                    <input type="hidden" name="urn" id="urn" value="' . $_GET['urn'] . '">');
            ?>
            <div class="row">
              <div class="col-xs-3"></div>
              <div class="col-xs-6">
                <input type="submit" name="save" class="form-control btn btn-primary" value="Save">
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
