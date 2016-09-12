<?php
    require("common.php");
    if(empty($_SESSION['user'])) {
        header("Location: login.php");
        die("Redirecting to login.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Homepage</title>
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
	  <div class="row">
      <div class="col-sm-6">
        <div class="panel panel-info">
          <div class="panel-heading" style="text-align: center;">Views</div>
          <div class="panel-body" style="padding-top: 35px;">
            <?php
                $query = "SELECT id, name, description FROM view
                          WHERE view.user_id = :user_id";
                $query_params = array(':user_id' => $_SESSION['user']['username']);
                try {
                    $stmt = $db->prepare($query);
                    $result = $stmt->execute($query_params);
                } catch(PDOException $ex) {
                    die("Failed to run query: " . $ex->getMessage());
                }
                while($row = $stmt->fetch()) {
                  print('<div class="well">
                          <h4 style="text-align: center;">' . $row['name'] . '</h4>' .
                          "<b>Description:</b> " . $row['description'] .
                          '<br/><div style="text-align: center; padding-top: 10px;">
                            <a class="btn btn-info" href="edit_view.php?id=' . $row['id'] . '" role="button">Edit View</a>
                            <a class="btn btn-success" href="view.php?id=' . $row['id'] . '" role="button">Enter View</a>
                            <a class="btn btn-danger" role="button" disabled="disabled">Delete View</a>
                          </div>
                        </div>');
                }
            ?>
          </div>
          <ul class="list-group">
            <li class="list-group-item">
              <a class="btn btn-default" href="new_view.php" role="button">New View</a>
            </li>
          </ul>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading" style="text-align: center;">Datasets</div>
          <ul class="list-group">
            <li class="list-group-item" style="padding-top: 25px;">
              <?php
                  $query = "SELECT dataset.id, dataset.name, dataset.description, dataset.source
                            FROM dataset, datapermission
                            WHERE datapermission.user_id = :user_id
                            AND datapermission.data_id = dataset.id";
                  $query_params = array(':user_id' => $_SESSION['user']['username']);
                  try {
                      $stmt = $db->prepare($query);
                      $result = $stmt->execute($query_params);
                  } catch(PDOException $ex) {
                      die("Failed to run query: " . $ex->getMessage());
                  }
                  while($row = $stmt->fetch()) {
                    print('<div class="well">
                            <h4 style="text-align: center;">' . $row['name'] . '</h4>' .
                            "<b>Description:</b> " . $row['description'] .
                            "<br/><b>Source:</b> " . $row['source'] .
                            '<br/><div style="text-align: center; padding-top: 10px;">
                              <a class="btn btn-info" href="edit_dataset.php?id=' . $row['id'] . '" role="button">Edit Dataset</a>
                              <a class="btn btn-info" href="manage_users.php?id=' . $row['id'] . '" role="button">Manage Users</a>
                              <a class="btn btn-danger" role="button" disabled="disabled">Delete Dataset</a>
                            </div>
                          </div>');
                  }
                ?>
            </li>
            <li class="list-group-item">
              <a class="btn btn-default" href="new_dataset.php" role="button">New Dataset</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="panel panel-info">
          <div class="panel-heading" style="text-align: center;">Plugins</div>
          <ul class="list-group">
            <li class="list-group-item" style="padding-top: 25px;">
              <?php
                  $query = "SELECT urn, name, description FROM plugin
                            WHERE owner = :user_id";
                  $query_params = array(':user_id' => $_SESSION['user']['username']);
                  try {
                      $stmt = $db->prepare($query);
                      $result = $stmt->execute($query_params);
                  } catch(PDOException $ex) {
                      die("Failed to run query: " . $ex->getMessage());
                  }
                  while($row = $stmt->fetch()) {
                    print('<div class="well">
                            <h4 style="text-align: center;">' . $row['name'] . '</h4>' .
                            "<b>Description:</b> " . $row['description'] .
                            '<br/><div style="text-align: center; padding-top: 10px;">
                              <a class="btn btn-info" href="edit_plugin.php?urn=' . $row['urn'] . '" role="button">Edit Plugin</a>
                              <a class="btn btn-danger" role="button" disabled="disabled">Delete Plugin</a>
                            </div>
                          </div>');
                  }
                ?>
            </li>
            <li class="list-group-item">
              <a class="btn btn-default" href="new_plugin.php" role="button">New Plugin</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
	</div>
	</div>
	</div>
	</div>
	</div>
</body>
</html>
