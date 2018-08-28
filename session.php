<?php 

	session_start();
	
	if($_SESSION['email']){
		echo "You are now logged in!";
	}
	else{
		header("Location: index.php");
	}


?>
