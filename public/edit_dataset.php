<?php
    require("common.php");
    if(empty($_SESSION['user'])) {
        header("Location: login.php");
        die("Redirecting to login.php");
    }

    if(empty($_POST)) {
        // CHECK USER HAS PERMISSION
        $query = "SELECT * FROM datapermission WHERE data_id = :data_id AND user_id = :user_id";
        $query_params = array(
            ':data_id' => $_GET['id'],
            ':user_id' => $_SESSION['user']['username']
        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch(PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $row = $stmt->fetch();
        if(empty($row)) {
            header("Location: homepage.php");
            die("Redirecting to homepage.php");
        }
    } else {
        if(empty($_POST['name'])) {
            die("Please enter a name.");
        }
        if(empty($_POST['source'])) {
            die("Please enter a source.");
        }

        $query = "UPDATE dataset SET name = :name,
                  source = :source";
        $query_params = array(
            ':name' => $_POST['name'],
            ':source' => $_POST['source'],
            ':id' => $_POST['id']
        );
        if(!empty($_POST['desc'])) {
            $query .= ", description = :desc";
            $query_params[':desc'] = $_POST['desc'];
        }
        if(!empty($_POST['prefix'])) {
            $query .= ", prefix_list = :prefix";
            $query_params[':prefix'] = $_POST['prefix'];
        }
        if(!empty($_POST['variable'])) {
            $query .= ", variable_list = :variable";
            $query_params[':variable'] = $_POST['variable'];
        }
        $query .= " WHERE id = :id";
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
	<title>Edit Dataset</title>
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
    <h1 style="text-align: center;">Edit Dataset</h1>
	  <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6">
        <form action="edit_dataset.php" method="post" name="edit_dataset_form" id="edit_dataset_form">
          <fieldset>
            <?php
              // GATHER INFO ABOUT THIS DATASET
              $query = "SELECT * FROM dataset WHERE id = :id";
              $query_params = array(':id' => $_GET['id']);
              try {
                  $stmt = $db->prepare($query);
                  $result = $stmt->execute($query_params);
              } catch(PDOException $ex) {
                  die("Failed to run query: " . $ex->getMessage());
              }
              $row = $stmt->fetch();
              print('<div class="form-group">
                      <label for="name">Name:</label>
                      <input type="text" name="name" class="form-control" id="name" value="' . $row['name'] . '">
                    </div>
                    <div class="form-group">
                      <label for="desc">Description:</label>
                      <textarea name="desc" class="form-control" rows="3" id="desc">' . $row['description'] . '</textarea>
                    </div>
                    <div class="form-group">
                      <label for="source">Source:</label>
                      <input type="text" name="source" class="form-control" id="source" value="' . $row['source'] . '">
                    </div>
                    <div class="form-group">
                      <label for="prefix">Prefix List:</label>
                      <textarea name="prefix" class="form-control" rows="3" id="prefix">' . $row['prefix_list'] . '</textarea>
                    </div>
                    <div class="form-group">
                      <label for="variable">Variable List:</label>
                      <textarea name="variable" class="form-control" rows="3" id="variable">' . $row['variable_list'] . '</textarea>
                    </div>
                    <input type="hidden" name="id" id="id" value="' . $_GET['id'] . '">');
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
