<?php
include "login_functions.php";

$usr = $pwd = $usrErr = $pwdErr = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST['usr']))
		$usrErr = 'Enter your username';
	else {
		$user = test_input_username($_POST['usr']);
		# Database check username
		
	}
	if (empty($_POST['pwd']) or empty($_POST['r-pwd'])) {
		$pwdErr = 'Enter a password';	
	}	
	else {	
		$password = test_input_password($_POST['pwd']);
		$rassword = test_input_password($_POST['r-pwd']);
		if (strcmp($password, $rassword) !== 0)
			$pwdErr = 'Passwords do not match';
		 
	        elseif (empty($usrErr)) {
			# Database add user and password
			
			# Redirect
			ifheader('Location: http://localhost/hola.php');
			exit();
		}
	
	}
}

?>

<!-- ----------------- HTML DOCUMENT --------------------- -->
<html>
<head>
<link rel="stylesheet" type="text/css" href="/SisDis/proyecto/accounts/login-forms.css">
</head>
<body>
<div class="title"><h1>Then sign up you motherfucker</h1></div>
<div class="form-box">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<fieldset>
<table>
<tr>
<td>Username</td>
<td><input name=usr></td>
<td><span class="error"><?php echo $usrErr;?></span></td>
</tr><tr>
<td>Password</td>
<td><input type=password name=pwd></td>
<td><span class="error"><?php echo $pwdErr;?></span></td>
</tr><tr>
</tr><tr>
<td>Repeat password</td>
<td><input type=password name=r-pwd></td>
<td></td>
</tr><tr>
<td></td>
<td><input type=submit value="Sign up"></td>
<td></td>
</tr>
</table>
</fieldset>
</form>
</body>
</html>


