<?php
    require("common.php");
    if(empty($_SESSION['user'])) {
        header("Location: login.php");
        die("Redirecting to login.php");
    }

    if(!empty($_POST)) {
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            die("Invalid E-Mail Address");
        }

        // VALIDATE NEW EMAIL
        if($_POST['email'] != $_SESSION['user']['email']) {
            $query = "SELECT 1 FROM users WHERE email = :email";
            $query_params = array(':email' => $_POST['email']);
            try {
                $stmt = $db->prepare($query);
                $result = $stmt->execute($query_params);
            } catch(PDOException $ex) {
                die("Failed to run query: " . $ex->getMessage());
            }
            $row = $stmt->fetch();
            if($row) {
                die("This E-Mail address is already in use");
            }
        }

        // NEW PASSWORD RE-ENCRYPT
        if(!empty($_POST['password'])) {
            // PASSWORDS MATCH
            if($_POST['password'] != $_POST['password_re']) {
                die("Passwords do not match");
            }
            $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
            $password = hash('sha256', $_POST['password'] . $salt);
            for($round = 0; $round < 65536; $round++) {
                $password = hash('sha256', $password . $salt);
            }
        } else {
            $password = null;
            $salt = null;
        }

        // UPDATE EMAIL, ...
        $query = "UPDATE users SET email = :email";
        $query_params = array(
            ':email' => $_POST['email'],
            ':user_id' => $_SESSION['user']['username'],
        );

        // PASSWORD, ...
        if($password !== null) {
            $query .= ", password = :password, salt = :salt";
            $query_params[':password'] = $password;
            $query_params[':salt'] = $salt;
        }

        // DESC, ...
        if(!empty($_POST['desc'])) {
            $query .= ", bio = :bio";
            $query_params[':bio'] = $_POST['desc'];
        }

        // NAME, ...
        if(!empty($_POST['name'])) {
            $query .= ", name = :name";
            $query_params[':name'] = $_POST['name'];
        }

        // for just our user...
        $query .= "WHERE id = :user_id";
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch(PDOException $ex) {
          die("Failed to run query: " . $ex->getMessage());
        }

        // UPDATE SESSION DATA
        $_SESSION['user']['email'] = $_POST['email'];
        header("Location: homepage.php");
        die("Redirecting to homepage.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Edit Account</title>
  <link rel="stylesheet" href="webroot/css/login_style.css">
	<link rel="stylesheet" type="text/css" href="webroot/css/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="webroot/css/bootstrap-adjust.css"/>
	<script type="text/javascript" src="webroot/js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="webroot/js/bootstrap.js"></script>
</head>
<body>
  <div class="login-card">
    <h1>Edit Account</h1>
    <br>
    <form action="register.php" method="post" name="registration_form" id="registration_form">
      <fieldset>
        <div style="text-align: center;">
          Username: <b><?php echo htmlentities($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8'); ?></b>
          <br/>
          (leave blank for no changes)
        </div><br/>
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" name="name" class="form-control" id="name" placeholder="name">
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="text" name="email" class="form-control" id="email" value="<?php echo htmlentities($_SESSION['user']['email'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="password">
        </div>
        <div class="form-group">
          <label for="password_re">Retype Password:</label>
          <input type="password" name="password_re" class="form-control" id="password_re" placeholder="password">
        </div>
        <div class="form-group">
          <label for="bio">Bio:</label>
          <textarea name="bio" class="form-control" rows="3" id="bio"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" name="save" class="form-control btn btn-primary" value="Save">
        </div>
			</fieldset>
    </form>
    <div class="login-help">
      <a href="homepage.php">Homepage</a>
    </div>
  </div>
</body>
</html>
