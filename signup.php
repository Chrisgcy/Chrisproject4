<?php 

    session_start();
    $errmsg = array();

    $myusername = $_POST["input_username"];
    $mypassword=$_POST["input_password"]; 
    $myconfirmpassword=$_POST["input_confirm_password"]; 
    
    if (isset($myusername) && ($mypassword != $myconfirmpassword)) {
        array_push($errmsg, "Confirm password failed.");

    } elseif( isset($myusername) ) {

        // Connect to server and select databse.
        include("db_connect.inc.php");

        // username and password sent from form 
        $mypassword = md5($mypassword);
        $mybirthday=$_POST["input_birthday"]; 
        $mycity=$_POST["input_city"]; 

        // To protect MySQL injection (more detail about MySQL injection)
        $myusername = stripslashes($myusername);
        $mypassword = stripslashes($mypassword);
        $mybirthday = stripslashes($mybirthday);
        $mycity = stripslashes($mycity);
        $myusername = mysql_real_escape_string($myusername);
        $mypassword = mysql_real_escape_string($mypassword);
        $mybirthday = mysql_real_escape_string($mybirthday);
        $mycity = mysql_real_escape_string($mycity);

        $sql = "SELECT * FROM $user_tbl_name WHERE uname='$myusername'";
        $result = mysql_query($sql);
        
        // Mysql_num_row is counting table row
        $count = mysql_num_rows($result);

        // If result matched $myusername and $mypassword, table row must be 1 row
        if($count==1) {
            array_push($errmsg, "User name has been used.");
        } else {
            $sql = "INSERT INTO $user_tbl_name VALUES ('$myusername', '$mypassword','$mybirthday', '$mycity', now())";
            error_log("sql ".$sql);
            $result = mysql_query($sql);
            if($result) {
                // Register $myusername, $mypassword and redirect to file "login_success.php"
                $_SESSION['uname'] = $myusername;
                header("location:wall.php");
            } else {
                array_push($errmsg, "Cannot connect to database.");
            } 
        }
    } 
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Sign-up</title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <!-- Bootstrap core CSS -->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap-theme.min.css" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js"></script>

</head>

<body>
	<div class="container">
        <?php
            foreach ($errmsg as &$err) {
                echo "<div class=\"alert alert-danger\">$err</div>";
            }
		?>
        <h2 class=""> Sign Up Here</h2>
		<form class="form-horizontal well" method="post" id="signup_form" action="signup.php">
            
			<div class="form-group">
				<label for= "input_username" class="col-xs-2 control-label"> User Name * </label>
				<div class="col-xs-6">
					<input type="text" class="form-control" name="input_username" placeholder="Name" required>
				</div>	
			</div>	

			<div class="form-group">
				<label for= "input_birthday" class="col-xs-2 control-label"> Date of Birth * </label>
				<div class="col-xs-6" id="input_birthday">
					<input type="date" class="form-control" name="input_birthday" placeholder="MM/DD/YYYY" required>	
				</div>	
			</div>	

			<div class="form-group">
				<label for= "input_city" class="col-xs-2 control-label"> City * </label>
				<div class="col-xs-6">
					<input type="text" class="form-control" name="input_city" placeholder="where you live now" required>
				</div>	
			</div>	

			<div class="form-group">
				<label for= "input_password" class="col-xs-2 control-label"> Password * </label>
				<div class="col-xs-6">
					<input type="password" class="form-control" name="input_password" required>
				</div>	
			</div>	

			<div class="form-group" id="confirm_password_section">
				<label for= "input_confirm_password" class="col-xs-2 control-label"> Confirm Password * </label>
				<div class="col-xs-6">
					<input type="password" class="form-control" name="input_confirm_password" required>
				</div>
			</div>

			<div class="form-group">
				<div class="col-xs-3"></div>
				<button type="submit" class="btn btn-primary col-xs-4" id="submit_btn"> Sign me Up </button>
			</div>

		</form>
	</div>

	<script type="text/javascript">
    $(document).ready(function () {
        $("#signup_form").submit(function(){
            if (!( $('#input_password').val() == $('#input_confirm_password').val())){
                $('#confirm_password_section').addClass("has-error");
                $('#confirm_password_section').addClass("has-feedback");
                //alert('Form is not submitting');
				return false;
			} else {
				$('#confirm_password_section').removeClass("has-error");
				$('#confirm_password_section').removeClass("has-feedback");
				return true;
			}
		});
		/*
			$('#submit_btn').click(function(){

				if (!( $('#input_password').val() == $('#input_confirm_password').val())){
					$('#confirm_password_section').addClass("has-error");
					$('#confirm_password_section').addClass("has-feedback");	


					
				} else {
					$('#confirm_password_section').removeClass("has-error");
					$('#confirm_password_section').removeClass("has-feedback");	

					//$('form').submit();

				}
				
			});
    	*/
	});
	</script>
</body>
</html>   
