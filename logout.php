<?php
session_start();
session_unset();
session_destroy();
header("Location: 1index.php"); 
exit();
?>