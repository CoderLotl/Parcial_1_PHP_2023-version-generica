<?php
require './config/defines.php';
require './config/autoLoader.php';

$app = new RequestsManager();
$app->Run();

?>