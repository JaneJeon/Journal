<?php
session_start();
require_once '../functions.php';

SessionManager::checkUser($_SESSION);
Mood::graph($_SESSION['valid_user']);

$p = new Page('Mood history', true);
$p->displayHeader(); ?>

<h1>Mood Graph for <?= htmlspecialchars($_SESSION['valid_user']) ?></h1>
<div class="text-center">
	<img src="../Model/mood.png">
</div>

<?php $p->displayFooter();