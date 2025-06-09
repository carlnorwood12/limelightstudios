<!-- unset session variables and destroy the session and redirect to index.php -->
<?php  
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit;