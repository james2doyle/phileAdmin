<?php

include 'Parsedown.php';
$parsedown = new Parsedown();
echo $parsedown->parse($_POST['data']);
 ?>
