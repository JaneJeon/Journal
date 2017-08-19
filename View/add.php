<?php
session_start();
require_once '../functions.php';

SessionManager::checkUser($_SESSION, 'add');

$i = new Input($_SESSION, $_POST);
$i->entryCheck();

$p = new Page('Journal entry', true);
$p->displayHeader();
$i->entryBody(); ?>

<h1>Diary/Mood Entry for <?= htmlspecialchars($_SESSION['valid_user']) ?></h1>

<form action="add.php" method="post">
	<label for="type">Input type</label>
	<input type="radio" name="type" id="type" value="Diary checked">Diary
	<input type="radio" name="type" id="type" value="Mood">Mood<br />
	
	<label for="input">Corresponding text/value</label>
	<textarea name="input" id="input" rows="10" cols="50"></textarea>
	
	<p class="input"><input type="submit" value="Submit"/></p>
</form>

<?php $p->displayFooter();