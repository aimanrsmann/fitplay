<?php	
session_start();
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Refresh:1; url=login.php", true, 303);
?>
