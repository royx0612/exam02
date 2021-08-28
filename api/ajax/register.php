<?php

include "../../class/database.class.php";

$db = new Database($_POST['table']);
unset($_POST['table']);
$db->create($_POST);
