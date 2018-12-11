<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_eplay = "localhost";
$database_eplay = "eplay";
$username_eplay = "root";
$password_eplay = "66666666";
$eplay = mysql_pconnect($hostname_eplay, $username_eplay, $password_eplay) or trigger_error(mysql_error(),E_USER_ERROR); 
?>