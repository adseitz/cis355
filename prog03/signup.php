<?php 

session_start();
	
require 'database.php';


if ( !empty($_POST)) { // if not first time through
	// initialize user input validation variables
	$nameError = null;
	$emailError = null;
	$mobileError = null;
	$passwordError = null;
	$titleError = null;
	
	// initialize $_POST variables
	$name = $_POST['name'];
	$email = $_POST['email'];
	$mobile = $_POST['mobile'];
	$password = $_POST['password'];
	$password = MD5($password);
	$title =  $_POST['title'];

	
	// validate user input
	$valid = true;
	if (empty($name)) {
		$nameError = 'Please enter a Name';
		$valid = false;
	}
	// do not allow 2 records with same email address!
	if (empty($email)) {
		$emailError = 'Please enter valid Email Address (REQUIRED)';
		$valid = false;
	} else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
		$emailError = 'Please enter a valid Email Address';
		$valid = false;
	}
	$pdo = Database::connect();
	$sql = "SELECT * FROM fr_persons";
	foreach($pdo->query($sql) as $row) {
		if($email == $row['email']) {
			$emailError = 'Email has already been registered!';
			$valid = false;
		}
	}
	Database::disconnect();
	
	// email must contain only lower case letters
	if (strcmp(strtolower($email),$email)!=0) {
		$emailError = 'email address can contain only lower case letters';
		$valid = false;
	}
	
	if (empty($password)) {
		$passwordError = 'Please enter valid Password';
		$valid = false;
	}
	if (empty($title)) {
		$titleError = 'Please enter valid Title';
		$valid = false;
	}

	// insert data
	if ($valid) 
	{
		$pdo = Database::connect();
		
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//writes and populates sql statement to be sent to database
		$sql = "INSERT INTO fr_persons (name,email,mobile,password,title) values(?, ?, ?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($name,$email,$mobile,$password,$title));
		
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM fr_persons WHERE email = ? AND password = ? LIMIT 1";
		$q = $pdo->prepare($sql);
		$q->execute(array($email,$password));
		$data = $q->fetch(PDO::FETCH_ASSOC);
		//sets session variables for id and title
		$_SESSION['fr_person_id'] = $data['id'];
		$_SESSION['fr_person_title'] = $data['title'];
		
		Database::disconnect();
		header("Location: signup.php");
	}
}
?>

<!-- HTML start -->
<!DOCTYPE html>

<html lang="en">

<!-- import bootstrap css and js -->
<head>
    <meta charset="utf-8">
    <link   href="css/bootstrap.min.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container">

		<div class="span10 offset1">
			<div class="row">
				<h3>Sign Up!</h3>
			</div>
	
			<form class="form-horizontal" action="signup.php" method="post" enctype="multipart/form-data">
				<!-- name input -->
				<div class="control-group <?php echo !empty($nameError)?'error':'';?>">
					<label class="control-label">Name</label>
					<div class="controls">
						<input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
						<?php if (!empty($nameError)): ?>
							<span class="help-inline"><?php echo $nameError;?></span>
						<?php endif; ?>
					</div>
				</div>
				<!-- email input -->
				<div class="control-group <?php echo !empty($emailError)?'error':'';?>">
					<label class="control-label">Email</label>
					<div class="controls">
						<input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
						<?php if (!empty($emailError)): ?>
							<span class="help-inline"><?php echo $emailError;?></span>
						<?php endif;?>
					</div>
				</div>
                <!-- mobile input -->
				<div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
					<label class="control-label">Mobile</label>
					<div class="controls">
						<input name="mobile" type="text" placeholder="mobile" value="<?php echo !empty($mobile)?$mobile:'';?>">
						<?php if (!empty($mobileError)): ?>
							<span class="help-inline"><?php echo $mobileError;?></span>
						<?php endif;?>
					</div>
				</div>
				<!-- password input -->
				<div class="control-group <?php echo !empty($passwordError)?'error':'';?>">
					<label class="control-label">Password</label>
					<div class="controls">
						<input id="password" name="password" type="password"  placeholder="password" value="<?php echo !empty($password)?$password:'';?>">
						<?php if (!empty($passwordError)): ?>
							<span class="help-inline"><?php echo $passwordError;?></span>
						<?php endif;?>
					</div>
				</div>
				<!-- title choice -->
				<div class="control-group">
					<label class="control-label">Title</label>
					<div class="controls">
						<select class="form-control" name="title">
							<option value="Volunteer" selected>Volunteer</option>
							<option value="Guest" selected>Guest</option>
							<option value="Hacker" selected>Hacker</option>
							<option value="Student" selected>Student</option>
							<!-- <option value="Administrator" >Administrator</option> -->
						</select>
					</div>
				</div>
			  
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Confirm</button>
					<a class="btn" href="login.php">Back</a>
				</div>
				
			</form>
			
		</div> <!-- end div: class="span10 offset1" -->
				
    </div> <!-- end div: class="container" -->
  </body>
</html>