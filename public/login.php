<?php
    require("common.php");
    $submitted_username = '';
    if(!empty($_POST)) {
        $query = "SELECT username, password, salt, email
            FROM user WHERE username = :username";
        $query_params = array(':username' => $_POST['username']);

        // CHECK PASSWORDS
        try  {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch(PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $login_ok = false;
        $row = $stmt->fetch();

        if($row) {
            $check_password = hash('sha256', $_POST['password'] . $row['salt']);
            for($round = 0; $round < 65536; $round++) {
                $check_password = hash('sha256', $check_password . $row['salt']);
            }
            if($check_password === $row['password']) {
                $login_ok = true;
            }
        }

        if($login_ok) {
            unset($row['salt']);
            unset($row['password']);
            $_SESSION['user'] = $row;
            header("Location: homepage.php");
            die("Redirecting to: homepage.php");
        } else {
            print("Login Failed.");
            $submitted_username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Log-in</title>
  <link rel="stylesheet" href="webroot/css/login_style.css">
	<link rel="stylesheet" type="text/css" href="webroot/css/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="webroot/css/bootstrap-adjust.css"/>
	<script type="text/javascript" src="webroot/js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="webroot/js/bootstrap.js"></script>
</head>
<body>
  <div class="login-card">
    <h1>Log-in</h1>
    <br>
    <form action="login.php" method="post" name="login_form" id="login_form">
      <fieldset>
        <div class="form-group">
          <input type="text" name="username" class="form-control" placeholder="username" value="<?php echo $submitted_username; ?>">
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="password">
        </div>
        <div class="form-group">
          <input type="submit" name="login" class="form-control btn btn-primary" value="Login">
        </div>
			</fieldset>
    </form>
    <div class="login-help">
      <a href="register.php">Register</a>
    </div>
  </div>
</body>
</html>
