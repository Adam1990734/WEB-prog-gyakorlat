<?php
//Ez is jó csak annyit tettem hozzá hogy meg is semmisíti a munkamenetet.
$data = $_SESSION;
unset($_SESSION["csn"]);
unset($_SESSION["un"]);
unset($_SESSION["login"]);
session_destroy();
?>