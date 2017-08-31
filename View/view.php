<?php
require_once '../functions.php';
session_start();

SessionManager::checkUser($_SESSION);

$p = new Page('View entries', true);
$p->displayHeader(); ?>
<h1>View Entries for <?= htmlspecialchars($_SESSION['valid_user']) ?></h1>
<?php

$_SESSION['view'] = new View($_SESSION['valid_user']);
$_SESSION['view']->fetchDiary(); ?>

<button class="btn btn-block" id="loadMore">Load more entries</button>

<!--<form action="../Controller/loadEntry.php" method="get">-->
<!--    <button class="btn btn-primary" type="submit">Click me</button>-->
<!--</form>-->

<script>
    $('form').submit(function(e) {
        if ($(this).find('textarea').val() === '')
            e.preventDefault()
    })
    $('#loadMore').click(function() {
        $.load('testoutput.php');
    })
</script>

<?php $p->displayFooter();