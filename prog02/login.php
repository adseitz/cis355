<?php
	//start session
	session_start();
	require "database.php";
	
	//set error message to be displayed if there is one
	if($_GET) $errorMessage = $_GET['errorMessage'];
	else $errorMessage = '';
	
	if($_POST) {
		//set variables
		$success = false;
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password = MD5($password);
		//connect to DB
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//sql to be sent to DB
		$sql = "SELECT * FROM fr_persons WHERE email = ? AND password = ?";
		$q = $pdo->prepare($sql);
		$q->execute(array($username, $password));
		$data = $q->fetch(PDO::FETCH_ASSOC);

		//if login is a success, send to the index
		if($data) {
			$_SESSION["username"] = $username;
			header("Location: index.php");
		}
		//otherwise, send back to login screen with error showing
		else {
			header("Location: login.php?errorMessage=Invalid login");
			exit();
		}
		
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="padding: 20px;">
<a class="btn btn-info" href="https://github.com/adseitz/cis355/tree/master/prog02">GITHUB CODE</a>
    <div class="container" style="width:300px;">	
		<h1>Log in</h1>
		<br>
		<form class="form-horizontal" action="login.php" method="post">
			<!-- shows error message, if present -->
			<p style="color: red; strong: bold;"><?php echo $errorMessage; ?></p>
			<!-- email input -->
			<p>Email:<input name="username" type="text" style="float:right;"placeholder="me@email.com" required></p>
			<!-- password input -->
			<p>Password:<input name="password" type="password" style="float:right;" placeholder="password"required></p>
			<br>
			<button type="submit" class="btn btn-success">Sign In</button>
			<a href='logout.php' class="btn btn-warning"> Log out </a>
		</form>
		<a href='signup.php' class="btn btn-primary"> Sign up! </a>
	</div>
</body>

</html>