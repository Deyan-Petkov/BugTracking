<?php
/* Log out process, unsets and destroys session variables */
session_start();
session_unset();
session_destroy();
echo "<script type='text/javascript'>window.location.href = '../index.php';</script>";
