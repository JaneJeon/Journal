<?php
require_once '../functions.php';
session_start();

SessionManager::authenticate($_SESSION, $_POST);

# want to preserve search results even if they visit some other page and then return
# ie. /search.php?query=htmlspecialchars(blah)&page=n
# even if you come back, load back exactly n pages (although it might be in different order)
if (!isset($_GET['query']))
    Route::redirect();

$p = new Page('Search results', true);
$p->displayHeader(); ?>

<h1>Search results for <?= htmlspecialchars($_GET['query']) ?></h1>
<?php

$v = new View($_SESSION['valid_user']);

$v->footerInformation();
$p->displayFooter();