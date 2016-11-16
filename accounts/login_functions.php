<?php

/** 
 * Test unsername entered by user.
 *
 * @param Place   $where  Where something interesting takes place
 * @return Tested data
 */
function test_input_username($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        if (!preg_match("/^[a-zA-Z ]*$/",$data)) {
        	global $usrErr;
		$usrErr = "Only letters and white space allowed";

        }
        return $data;
}

/** 
 * Test password entered by user.
 *
 * @param string  $data  Where something interesting takes place
 * @return Tested data
 */
function test_input_password($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        if (!preg_match("/^[0-9a-zA-Z_]*$/",$data)) {
        	global $pwdErr;
		$pwdErr = "Only letters, numbers and underscores allowed";
        }
        return $data;
}
?>
