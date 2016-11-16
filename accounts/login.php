<?php
include "login_functions.php";

$usr = $pwd = $usrErr = $pwdErr = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST['usr']))
		$usrErr = 'Enter username';
	else {
		$user = test_input_username($_POST['usr']);
		
	}
	if (empty($_POST['pwd'])) {
		$pwdErr = 'Enter password';	
	}	
	else {	
		$password = test_input_password($_POST['pwd']); 
		
	}
	if (empty($usrErr) and empty($pwdErr)) {
		# Database check user and password
	}
}


?>

<!-- ----------------- HTML DOCUMENT --------------------- -->
<html>
<head>
<link rel="stylesheet" type="text/css" href="/SisDis/proyecto/accounts/login-forms.css">
</head>
<body>
<div class="title"><h1>Log in with your username and password</h1><div>
<div class="form-box">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
<fieldset>
<table>
<tr>
<td>User</td>
<td><input name=usr></td>
<td><span class="error"><?php echo $usrErr;?></span></td>
</tr><tr>
<td>Password</td>
<td><input type=password name=pwd></td>
<td ><span class="error"><?php echo $pwdErr;?></span></td>
</tr><tr>
<td></td>
<td><input type=submit value="Log in"></td>
<td><a href=/SisDis/proyecto/accounts/signup.php>I still don't have an account, macho</a></td>
</tr>
<table>
</fieldset>
</form>
</body>
</html>



