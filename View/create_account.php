<?php
require_once '../functions.php';
session_start();
SessionManager::checkUser($_SESSION);

$p = new Page('Create Account');
$p->displayHeader(); ?>



<?php $p->displayFooter();