<?php
require_once '../functions.php';
session_start();

SessionManager::checkUser($_SESSION);

$p = new Page('View entries', true);
$p->displayHeader(); ?>

<h1>View Entries for <?= htmlspecialchars($_SESSION['valid_user']) ?></h1>
<?php

$_SESSION['view'] = new View($_SESSION['valid_user']);
$_SESSION['view']->fetchDiary();
$_SESSION['view']->footerInformation();
$p->displayFooter();