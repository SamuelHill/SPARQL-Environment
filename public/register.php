<?php
    require("common.php");

    // This if statement checks to determine whether the registration form has been submitted
    if(!empty($_POST)) {
        if(empty($_POST['username'])) {
            die("Please enter a username.");
            // FUTURE: DISPLAY ERROR ON FORM
        }
        if(empty($_POST['name'])) {
            die("Please enter a name.");
        }
        if(empty($_POST['password'])) {
            die("Please enter a password.");
        }
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            die("Invalid E-Mail Address");
        }

        // UNIQUE USERNAME
        $query = "SELECT 1 FROM user WHERE username = :username";
        $query_params = array(':username' => $_POST['username']);
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch(PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $row = $stmt->fetch();
        if($row) {
            die("This username is already in use");
        }

        // UNIQUE EMAIL
        $query = "SELECT 1 FROM user WHERE email = :email";
        $query_params = array(':email' => $_POST['email']);
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch(PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }
        $row = $stmt->fetch();
        if($row) {
            die("This email address is already registered");
        }

        // PASSWORDS MATCH
        if($_POST['password'] != $_POST['password_re']) {
            die("Passwords do not match");
        }

        // ENCRYPT PASSWORD
        $query = "INSERT INTO user (username, name, salt, password, email, bio)
                  VALUES (:username, :name, :salt, :password, :email, :bio)";
        $salt = dechex(mt_rand(0, 2147483647)) . dechex(mt_rand(0, 2147483647));
        $password = hash('sha256', $_POST['password'] . $salt);
        for($round = 0; $round < 65536; $round++) {
            $password = hash('sha256', $password . $salt);
        }
        $query_params = array(
            ':username' => $_POST['username'],
            ':name' => $_POST['name'],
            ':salt' => $salt,
            ':password' => $password,
            ':email' => $_POST['email'],
            ':bio' => $_POST['bio']
        );
        try {
            $stmt = $db->prepare($query);
            $result = $stmt->execute($query_params);
        } catch(PDOException $ex) {
            die("Failed to run query: " . $ex->getMessage());
        }

        header("Location: login.php");
        die("Redirecting to login.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Register</title>
  <link rel="stylesheet" href="webroot/css/login_style.css">
	<link rel="stylesheet" type="text/css" href="webroot/css/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="webroot/css/bootstrap-adjust.css"/>
	<script type="text/javascript" src="webroot/js/jquery-1.10.2.js"></script>
	<script type="text/javascript" src="webroot/js/bootstrap.js"></script>
</head>
<body>
  <div class="login-card">
    <h1>Register</h1>
    <br>
    <form action="register.php" method="post" name="registration_form" id="registration_form">
      <fieldset>
        <div class="form-group">
          <label for="username">Username:</label>
          <input type="text" name="username" class="form-control" id="username" placeholder="username">
        </div>
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" name="name" class="form-control" id="name" placeholder="name">
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="text" name="email" class="form-control" id="email" placeholder="example@email.com">
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
          <input type="submit" name="register" class="form-control btn btn-primary" value="Register">
        </div>
			</fieldset>
    </form>
  </div>
</body>
</html>
