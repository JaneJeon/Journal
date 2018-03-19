<?php
session_start();
require_once '../functions.php';

SessionManager::checkUser($_SESSION);
$p = new Page('Journal entry', true);
$p->displayHeader(); ?>

<h1>To-do List for <?= htmlspecialchars($_SESSION['valid_user']) ?></h1>

<?php $p->displayFooter();