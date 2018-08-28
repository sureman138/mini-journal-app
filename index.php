<?php
ob_start();
session_start();
$err = "";
if(array_key_exists("logout", $_GET)){
	unset($_SESSION['customerEmail']);
	setcookie("customerEmail", "", time() - 60*60);
	$_COOKIE["customerEmail"] = "";


}
else if((array_key_exists("customerEmail", $_SESSION) AND $_SESSION['customerEmail'] !="")
	OR (array_key_exists("customerEmail", $_COOKIE) AND $_COOKIE['customerEmail'] != "")){
	header("Location: login.php");
}

if(isset($_POST["signUp"])){
	$link = mysqli_connect("shareddb-i.hosting.stackcp.net", "userDB2-33354ef8", "2ky318jbca", "userDB2-33354ef8");
	$password = $_POST['passwordOne'];
	$pwregex = '/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,100}$/';
	$eregex = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
	if(mysqli_connect_error()){
		die("There was an error connecting to the database");
	}
		if(empty($_POST['emailOne'])){
			 $err .= "<p>Email address is required</p>";
		}
		if(!preg_match($eregex, $_POST['emailOne'])){
			$err .= "<p>Please enter a valid email address</p>";
		}

		if(empty($_POST['passwordOne'])){
			$err .= "<p>Password is required</p>";
		}
		if(!preg_match($pwregex, $password)){
			$err .= "<p>Password must be between at least 8 characters, contain 1 letter, 1 number, and 1 of the following: !@#$%</p>";
		}

		if($err != "") {
			$err ='<div class="alert alert-danger" role="alert"><strong>There were error(s) in your sign-up form: </strong>'.$err.'</div>';

		}
		else {
		$query = "SELECT `id` FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST["emailOne"])."'";

		$result = mysqli_query($link, $query);

		if(mysqli_num_rows($result) > 0){
				$err = '<div class="alert alert-danger" role="alert">That email is in use!</div>';
		}

		else{

		$hash = password_hash($_POST["passwordOne"], PASSWORD_DEFAULT);
		$query = "INSERT into `users` (email, password) VALUES ('".mysqli_real_escape_string($link, $_POST['emailOne'])."','".mysqli_real_escape_string($link, $hash)."')";

		if(mysqli_query($link, $query)) {
			$_SESSION['customerEmail'] = $_POST['emailOne'];
			if(isset($_POST['checkboxOne'])){
				setcookie("customerEmail",$_POST['emailOne'], time() + 60 * 60);
			}
			$queryTwo = "INSERT INTO styles (userid)
			SELECT id
			FROM users
			WHERE email = '".mysqli_real_escape_string($link, $_POST['emailOne'])."'";

			mysqli_query($link, $queryTwo);

			header("Location: login.php");


		}


	}


}
}

if(isset($_POST["logIn"])){
	$link = mysqli_connect("shareddb-i.hosting.stackcp.net", "userDB2-33354ef8", "2ky318jbca", "userDB2-33354ef8");

 	if(mysqli_connect_error()){
		die("There was an error connecting to the database");
	}
		if(empty($_POST['emailTwo'])){
			 $err .="<p>email address is required</p>";
		}

		if(empty($_POST['passwordTwo'])){
			$err .= "<p>password is required</p>";
		}

		if($err != "") {
			$err ='<p><strong>There were error(s) in your login form:</strong></p>'.$err;
			echo $err;
		}

		else {
			$query = "SELECT password from users WHERE email = '".mysqli_real_escape_string($link, $_POST["emailTwo"])."'";
			$result = mysqli_query($link, $query);
			$row = mysqli_fetch_array($result);

			if(password_verify($_POST['passwordTwo'], $row['password'])){
			$query = "SELECT * FROM `users` WHERE email = '".mysqli_real_escape_string($link, $_POST["emailTwo"])."'";

			$result = mysqli_query($link, $query);

			if(mysqli_num_rows($result) > 0){
			$_SESSION['customerEmail'] = $_POST['emailTwo'];
				if(isset($_POST['checkboxTwo'])){
					setcookie("customerEmail",$_POST['emailTwo'], time() + 60 * 60);
				}


			header("Location: login.php");
				}
			}

		else{
			$err = '<div class="alert alert-danger" role="alert">The log in information does not match our records</div>';

		}
		}

}

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<style type="text/css">
		body{
			background-image: url(rsz_library.png);
			background-position:center;
			background-attachment:fixed;
			background-size: cover;
		}
		.jumbotron{
			margin: 0 auto;
			width:50%;
			height:100%;
			background: none;

		}
		#formTwo{
			display:none;
		}
		#labelTwo{
			float:left;
		}
		#checkboxTwo {
			margin-top:7px;
			margin-left:5px;
		}
		.error{
			width:65%;
		}
		#labelOne{
			float:left;
		}
		#checkboxOne{

				margin-top:7px;
				margin-left:5px;
		}

		@media(max-width:768px){
			#formOne p, #formTwo  p, #formOne label, #formTwo label{
				color: #428bca !important;
			}
		}

	</style>
  <title>Secret Diary</title>
  </head>
  <body>

  <div class="jumbotron">
	<h1 class="display-3" style="color:white">Secret Diary</h1>
	<p class="lead" style="color:white">Store your thoughts permanently and securely</p>

		<div id="formOne" class="form-inline justify-content-left">
			<div id="error" class="error"><?php echo $err ?></div>

			<form method="post">
				<p style="color:white">Interested? Sign up now.</p>

				<input type="email" class="form-control" id= "emailOne" name="emailOne" placeholder="Your Email">

				<input type="password" class = "form-control" id= "passwordOne" name="passwordOne" placeholder="Password">
				<p><label id="labelOne" for="checkboxOne" style="color:white">Stay logged in?</label>
				<input type="checkbox" id="checkboxOne" name="checkboxOne"></p>

				<button id="signUp" class="btn btn-success" name="signUp" type="submit">Sign Up!</button>
				<br>
				<br>
				<p style="color:white">Already a member? Log in below!</p>
			</form>
		</div>

		<div id="formTwo" class="form-inline justify-content-center">
			<form method="post">
				<p style="color:white">Log in with your username and password.</p>

				<input type="email" class="form-control" name="emailTwo" placeholder="Your Email">

				<input type="password" class="form-control" name="passwordTwo" placeholder="Password">
				<p><label id="labelTwo" for="checkboxTwo" style="color:white">Stay logged in?</label>
				<input type="checkbox" id="checkboxTwo" name="checkboxTwo"></p>

				<button id="logIn" class="btn btn-success" name="logIn" type="submit">Log In!</button>
				<br>
				<br>
				<p style="color:white">Want to join? Sign up today!</p>
			</form>
		</div>

		<p><button class="btn btn-primary" id="formToggle" type="submit">Switch to Log In!</button></p>
	</div>


<script type="text/javascript">

$("#formToggle").click(function() {
	var newText = ($(this).text() == "Switch to Log In!")? "Switch to Sign Up!" : "Switch to Log In!";
	$(this).text(newText);
	$("#formTwo").toggle("slow");
	$("#formOne").toggle("slow");
});
function isEmail(email) {
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	var isAnEmail = re.test(email.toLowerCase());
	return isAnEmail;
}
function passwordCheck(password) {
  var re = new RegExp(/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,100}$/);
var isPassword = re.test(password);
return isPassword;
}
$("#formOne").submit(function(e){
	var error = "";
	var email = $("input[name=emailOne]").val();
	var password = $("#passwordOne").val();
	if(!isEmail(email)){
		//$("#error").html('<div class="alert alert-danger" role="alert">Please Enter A Valid Email Address</div>');
		error += "<p>Please enter a valid email address</p>";

	}
	if(!passwordCheck(password)){
		error += "<p>Password must be between at least 8 characters, contain 1 letter, 1 number, and 1 of the following: !@#$%</p>"
	}
	if(error != ""){
		$("#error").html('<div class="alert alert-danger" role="alert"><strong>The following error(s) were in your form: </strong>' + error + '</div>');
		return false;
	}

	else {
		return true;
	}
})


/*$("#formTwo").submit(function(e){
	var email = $("input[name=emailTwo]").val();
	if(!isEmail(email)){
		$("#error").html('<div class="alert alert-danger" role="alert">Please Enter A Valid Email Address</div>');
		e.preventDefault();

	}else {
		return true;
	}
})

*/




</script>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
