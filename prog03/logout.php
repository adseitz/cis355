<?php
	session_start();
	//destroys session
	session_destroy();
	//sends back to login screen
	header("Location: login.php");
?>