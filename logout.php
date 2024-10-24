<?php
   session_start();
   session_unset();
   if(session_destroy()) {
        header("Location: index.php");
        echo '<script language="javascript">';
        echo 'alert("Logout successful")';
        echo '</script>';
    }
?>