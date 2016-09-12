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
        // CHECK USER EXISTS
        $query = "SELECT * FROM user WHERE username = :username";
        $query_params = array(':username' => $_POST['username']);
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
        // ADD USER TO THE PERMISSIONS TABLE
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $query = "INSERT INTO datapermission (data_id, user_id)
                  VALUES (:data_id, :user_id)";
        $query_params = array(
            ':data_id' => $_POST['id'],
            ':user_id' => $_POST['username']
        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch(PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        header("Location: manage_users.php");
        die("Redirecting to manage_users.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Manage Users</title>
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
    <h1 style="text-align: center;">Manage Users</h1>
	  <div class="row">
      <div class="col-sm-3"></div>
      <div class="col-sm-6">
        <?php
          // GATHER INFO ABOUT THIS DATASET
          $query = "SELECT * FROM datapermission WHERE data_id = :id GROUP BY user_id";
          $query_params = array(':id' => $_GET['id']);
          try {
              $stmt = $db->prepare($query);
              $result = $stmt->execute($query_params);
          } catch(PDOException $ex) {
              die("Failed to run query: " . $ex->getMessage());
          }
          while($row = $stmt->fetch()) {
              print('<div class="well" style="text-align: center;"><b>' . $row["user_id"] . '</b>
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      <a class="btn btn-default" role="button" disabled="disabled">Revoke Access</a>
                    </div>');
          }
        ?>
        <form action="manage_users.php" method="post" name="manage_users_form" id="manage_users_form">
          <fieldset>
            <div class="form-group">
                <label for="username">New User:</label>
                <input type="text" name="username" class="form-control" id="username" placeholder="username">
            </div>
            <?php
              print('<input type="hidden" name="id" id="id" value="' . $_GET['id'] . '">');
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
