<?php


session_start();

$link = mysqli_connect("shareddb-i.hosting.stackcp.net", "userDB2-33354ef8", "2ky318jbca", "userDB2-33354ef8");
if(isset($_SESSION['customerEmail'])){
	$email = $_SESSION['customerEmail'];
}
else{
	header('Location: index.php');
}
if(mysqli_connect_error()){
		die("There was an error connecting to the database");
	}





function displayPost (){
	$link = mysqli_connect("shareddb-i.hosting.stackcp.net", "userDB2-33354ef8", "2ky318jbca", "userDB2-33354ef8");
	$email = $_SESSION['customerEmail'];
	$query = "SELECT text FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $email)."'";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	if($row['text'] != ""){
	echo $row['text'];
	}

}
function displayPad(){
	$link = mysqli_connect("shareddb-i.hosting.stackcp.net", "userDB2-33354ef8", "2ky318jbca", "userDB2-33354ef8");
	$email = $_SESSION['customerEmail'];
	$query = "SELECT styles.pad
	FROM styles
	INNER JOIN users
	ON styles.userid = users.id
	WHERE users.email = '".mysqli_real_escape_string($link, $email)."' LIMIT 1";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	if($row['pad'] != ""){
		echo $row['pad'];
	}

}
function displayBG(){
	$link = mysqli_connect("shareddb-i.hosting.stackcp.net", "userDB2-33354ef8", "2ky318jbca", "userDB2-33354ef8");
	$email = $_SESSION['customerEmail'];
	$query = "SELECT styles.background
	FROM styles
	INNER JOIN users
	ON styles.userid = users.id
	WHERE users.email = '".mysqli_real_escape_string($link, $email)."' LIMIT 1";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_array($result);
	if($row['background'] != ""){
		echo $row['background'];
	}

}




if(isset($_POST['text'])){
$link = mysqli_connect("shareddb-i.hosting.stackcp.net", "userDB2-33354ef8", "2ky318jbca", "userDB2-33354ef8");
$postId = $_POST['postId'];
$text = $_POST['text'];

$query = "UPDATE users
SET text = '".mysqli_real_escape_string($link, $text)."'
 WHERE email =  '".mysqli_real_escape_string($link, $_SESSION['customerEmail'])."' LIMIT 1";

mysqli_query($link, $query);
$result = mysqli_query($link, $query);
if(!$result){
	die('Invalid query: ' . mysqli_connect_error());
}
}

if(isset($_POST['padVal'])){

	$padVal =  $_POST['padVal'];
	$query = "UPDATE styles
	JOIN users on styles.userid = users.id
	SET styles.pad = '".mysqli_real_escape_string($link, $padVal)."'
	WHERE users.email = '".mysqli_real_escape_string($link, $email)."'";

	mysqli_query($link, $query);
	$result = mysqli_query($link, $query);
	if(!$result){
		die('Invalid query: ' . mysqli_connect_error());
	}
}

if(isset($_POST['bgVal'])){
	$bgVal = $_POST['bgVal'];
	$query = "UPDATE styles
	JOIN users on styles.userid = users.id
	SET styles.background = '".mysqli_real_escape_string($link, $bgVal)."'
	WHERE users.email = '".mysqli_real_escape_string($link, $email)."'";
	mysqli_query($link, $query);
	$result = mysqli_query($link, $query);
	if(!$result){
		die('Invalid query: ' . mysqli_connect_error());
	}
}



if(array_key_exists("customerEmail", $_COOKIE)) {
	$_SESSION['customerEmail'] = $_COOKIE['customerEmail'];

}







?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="icon" type="image/png" href="favicon-32x32.png" sizes="32x32" />
	<script
	src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style type="text/css">
		#text{
			width:70%;
			height:1000px;
			margin: 20px 20px 20px 15px;
			background:none;
			background-size:cover
			background-repeat: no-repeat;
			border:none;

		}
		nav{
			height: 40px;
		}
		body{
			background-image: url(bg1.jpg);
			background-attachment:fixed;
			background-size:cover;
			background-repeat: no-repeat;



		}
		#font-style-select{
			width:150px;

		}
		#font-color-select{
			width:150px;
		}
		#webmenu{
			width:200px;
		}
		.select{
			margin-left: 15px;
		}
		#textStyle{
			padding-left: 20px;
		}
		.pad{
			margin-top: 20px;
			width: 60px;
			height: 80px;
		}
		.bg{

			margin-top: 20px;
			width: 100px;
			height: 80px;
		}
		#displayPad{
			display:none;
		}
		#displayBG{
			display:none;
		}

	</style>
  </head>
  <body>
  <nav class="navbar">

	<a href="index.php?logout=1" button class="btn btn-outline-success my-2 my-sm-0 navbar-toggler ml-auto">Logout</a>
  </nav>
	<form id="form" method="post" class="form-inline">
		<select class="form-control btn-light select" id="font-style-select">
			<option selected="selected">Font Type</option>
			<option value='Lucida Console'>Lucida Console</option>
    	<option value='Courier New'>Courier New</option>
    	<option value='Consolas'>Consolas</option>
			<option value='Comic Sans MS'>Comic Sans MS</option>
			<option value='Arial Black'>Arial Black</option>
		</select>

		<select class="form-control btn-light select" id="font-color-select">
			<option selected="selected">Font Color</option>
			<option value='Black'>Black</option>
			<option value='Red'>Red</option>
    	<option value='Blue'>Blue</option>
    	<option value='White'>White</option>
			<option value='Orange'>Orange</option>
			<option value='Yellow'>Yellow</option>
		</select>
		<select class="form-control btn-light select" id="font-size-select">
			<option selected="selected">Font Size</option>
			<option value='10'>10</option>
			<option value='12'>12</option>
			<option value='14'>14</option>
			<option value='18'>18</option>
			<option value='20'>20</option>
		</select>
		<button type="button" class="btn btn-info select" data-toggle="modal" data-target="#padStyleModal">
			Change Notepad
		</button>

		<button type="button" class="btn btn-info select" data-toggle="modal" data-target="#backgroundStyleModal">
			Change Background
		</button>

		<div class="modal fade" id="padStyleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  	<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalLongTitle">Select Notepad Style</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          	<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
					<form method="post" id="padStyle">
	  		<div class="modal-body">

					<div class = "row">
						<div id="displayPad"><?php displayPad(); ?></div>
						<div class = "col-sm-6 col-md-3">
							 <input id="indexPad" type="image" class="pad" name='image' value="bg1.jpg" src='bg1.jpg'>
						</div>
				   <div class = "col-sm-6 col-md-3">
				      <input type="image" class="pad" name='image' value="edit1.jpg" src='edit1.jpg'>
				   </div>

				   <div class = "col-sm-6 col-md-3">
				      <input type="image" class="pad" name='image' value="edit2.jpg" src='edit2.jpg'>
				   </div>

				   <div class = "col-sm-6 col-md-3">
				      <input type="image" class="pad" value = "edit3.jpg" name='image' src='edit3.jpg'>
				   </div>

				   <div class = "col-sm-6 col-md-3">
				      <input type="image" class="pad" value ="edit4.jpg" name='image' src='edit4.jpg'>
				   </div>
					 <div class = "col-sm-6 col-md-3">
				      <input type="image" class="pad" name='image' value="edit5.jpg" src='edit5.jpg'>
				   </div>
					 <div class = "col-sm-6 col-md-3">
				      <input type="image" class="pad" name='image' value = "edit6.jpg" src='edit6.jpg'>
				   </div>
					 <div class = "col-sm-6 col-md-3">
				      <input type="image" class="pad" name='image' value="edit7.jpg" src='edit7.jpg'>
				   </div>

				 	</div>

	      	</div>
	      	<div class="modal-footer">
	        	<button type="button" name="padSubmit" class="btn btn-secondary" data-dismiss="modal">OK</button>

	      	</div>
				</form>
	    	</div>
	  	</div>
		</div>

		<div class="modal fade" id="backgroundStyleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  	<div class="modal-dialog modal-dialog-centered" role="document">
	    	<div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title" id="exampleModalLongTitle">Select Background</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          	<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div class="modal-body">
						<form method="post" id="bgStyle">
						<div class="row">
						<div id="displayBG"><?php displayBG(); ?></div>
						<div class = "col-sm-6 col-md-3">
							 <input type="image" class="bg" name='image' value="bg1.jpg" src='bg1.jpg'>
						</div>
				   <div class = "col-sm-6 col-md-3">
				      <input type="image" class="bg" name='image' value="bg2.jpg" src='bg2.jpg'>
				   </div>

				   <div class = "col-sm-6 col-md-3">
				      <input type="image" class="bg" name='image' value="bg3.jpg" src='bg3.jpg'>
				   </div>

				   <div class = "col-sm-6 col-md-3">
				      <input type="image" class="bg" value = "bg-4.jpg" name='image' src='bg-4.jpg'>
				   </div>

				   <div class = "col-sm-6 col-md-3">
				      <input type="image" class="bg" value ="bg5.jpg" name='image' src='bg5.jpg'>
				   </div>
					 <div class = "col-sm-6 col-md-3">
				      <input type="image" class="bg" name='image' value="bg6.jpg" src='bg6.jpg'>
				   </div>
					 <div class = "col-sm-6 col-md-3">
				      <input type="image" class="bg" name='image' value = "bg7.jpg" src='bg7.jpg'>
				   </div>
					 <div class = "col-sm-6 col-md-3">
				      <input type="image" class="bg" name='image' value="bg8.jpg" src='bg8.jpg'>
				   </div>
				 </div>

	      	</div>
	      	<div class="modal-footer">
	        	<button type="button submit" class="btn btn-secondary" data-dismiss="modal">OK</button>

	      	</div>
	    	</div>
	  	</div>
		</div>

		<textarea class="form-control" name="text" id="text" rows="3" placeholder="This is great!"><?php displayPost(); ?></textarea>
		<input type='hidden' id='postId' name='postId' value='0'>
	</form>


	<script type="text/javascript">

	var style = localStorage.getItem('fontStyle');
	var color = localStorage.getItem('fontColor');
	var size = localStorage.getItem('fontSize');

	if(style != ""){
		$("#text").css('font-family', style);
	}
	if(color != ""){
		$("#text").css('color', color);
	}
	if(size != ""){
		$("#text").css('font-size', size);
	}



	jQuery("#font-style-select option").each(function(){
		$(this).css("font-family", $(this).val());
	});
	jQuery("#font-color-select option").each(function(){
		$(this).css("color", $(this).val());
	});


	$(document).ready(
		function()
		{
    	$('#font-style-select').on( 'change',
        	function()
        	{
						var fontStyle = $('#font-style-select').val();
            $('#text').css( 'font-family', fontStyle );
            console.log( 'Font changed' );
						localStorage.setItem('fontStyle', fontStyle);
        	});
				});
	$(document).ready(
		function()
			{
				$('#font-color-select').on( 'change',
					function()
					{
							var fontColor = $('#font-color-select').val();
							$('#text').css( 'color', fontColor);
							console.log( 'Color changed' );
							localStorage.setItem('fontColor', fontColor);

					});
			});
		$(document).ready(
				function()
					{
						$('#font-size-select').on( 'change',
							function()
							{
									var fontSize = $('#font-size-select').val() + 'px';
									$('#text').css( 'font-size', fontSize );
									localStorage.setItem('fontSize', fontSize);
									console.log( $('#font-size-select').val() );
							});
					});
		$(document).delegate('#text', 'keydown', function(e) {
			 var keyCode = e.keyCode || e.which;

			 if (keyCode == 9) {
			   e.preventDefault();
			   var start = this.selectionStart;
			   var end = this.selectionEnd;

			    // set textarea value to: text before caret + tab + text after caret
			   $(this).val($(this).val().substring(0, start)
			              + "\t"
			              + $(this).val().substring(end));

			    // put caret at right position again
			    this.selectionStart =
			    this.selectionEnd = start + 1;
			  }
			});

		var bg = "";
		function displayPad(pad){


			if(pad == bg || pad == "bg1.jpg"){
				$("#text").css('background', 'none');
				$("#text").css('height', '1000px');
				$("#text").css('width', '70%');
				$("#text").css('padding-top', '0px');
				$("#text").css('padding-left', '0px');

			}
			else{
			$("#text").css('background-image', 'url(' + pad + ')');
			if(pad == 'edit1.jpg'){
				$("#text").css('padding-top', '130px');
				$("#text").css('padding-left', '130px');
				$("#text").css('height', '1000px');
				$("#text").css('width', '70%');
				$("#text").css('background-size', 'cover');
				$("#text").css('background-repeat', 'no-repeat');

			}
			else if(pad == 'edit2.jpg'){
				$("#text").css('padding-top', '100px');
				$("#text").css('padding-left', '100px');
				$("#text").css('height', '1000px');
				$("#text").css('width', '70%');

				$("#text").css('background-size', 'cover');
				$("#text").css('background-repeat', 'no-repeat');
			}

			else if(pad == 'edit3.jpg'){
				$("#text").css('padding-top', '100px');
				$("#text").css('padding-left', '100px');
				$("#text").css('height', '1500px');
				$("#text").css('width', '70%');
				$("#text").css('background-size', 'cover');
				$("#text").css('background-repeat', 'no-repeat');

			}

			else if(pad == 'edit4.jpg'){
				$("#text").css('padding-top', '130px');
				$("#text").css('padding-left', '50px');
				$("#text").css('height', '1500px');
				$("#text").css('width', '70%');

				$("#text").css('background-size', 'cover');
				$("#text").css('background-repeat', 'no-repeat');
			}

			else if(pad == 'edit5.jpg'){
				$("#text").css('padding-top', '150px');
				$("#text").css('padding-left', '140px');
				$("#text").css('height', '1000px');
				$("#text").css('width', '70%');
				$("#text").css('background-size', 'cover');
				$("#text").css('background-repeat', 'no-repeat');
			}

			else if(pad == 'edit6.jpg'){
				$("#text").css('padding-top', '40px');
				$("#text").css('padding-left', '50px');
				$("#text").css('height', '1000px');
				$("#text").css('width', '70%');
				$("#text").css('background-size', 'cover');
				$("#text").css('background-repeat', 'no-repeat');
			}

			else if(pad == 'edit7.jpg'){
				$("#text").css('padding-top', '60px');
				$("#text").css('padding-left', '40px');
				$("#text").css('height', '1000px');
				$("#text").css('width', '100%');
				$("#text").css('background-size', 'cover');
				$("#text").css('background-repeat', 'no-repeat');
			}
		}
		}
		$(".pad").click(function() {
			var pad = $(this).attr('src');
			displayPad(pad);


		});
		function displayBG(image){
			$("body").css('background-image', 'url(' + image + ')');

		}
		function displayThumb(image){

			$("#indexPad").attr('src', image);
		}
		$(".bg").click(function(){
			bg = $(this).attr('src');
			displayBG(bg);
			//$("#indexPad").attr('src', bg);
			displayThumb(bg);
			var bgVal = $(this).val();
			$.ajax({
				type: 'POST',
				url: 'login.php',
				data: {"bgVal": bgVal},

			});
			return false;
		});
		$('.pad').click(function(e){
			var padVal = $(this).val();

			$.ajax({
				type: 'POST',
				url: "login.php",
				data: {"padVal": padVal}

			});
			return false;
		});

		if($("#displayPad").html() != ""){
			var pad = $("#displayPad").html();
			displayPad(pad);
		}
		if($("#displayBG").html() != ""){
			var bg = $("#displayBG").html();
			displayBG(bg);
			displayThumb(bg);
		}


		var timer;
		var timeout = 1000;

		$("#text").keyup(function() {
			if(timer){
				clearTimeout(timer);
			}
			timer = setTimeout(saveText, timeout);
		});

		function saveText() {
			var postText = $("#text").val().trim();
			if(postText != ''){
				$.ajax({
					type:'POST',
					url: "login.php",
					data: jQuery("form").serialize(),




				});
			};

		};





	</script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
