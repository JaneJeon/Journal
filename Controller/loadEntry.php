<?php
require_once '../functions.php';
session_start();

# TODO: return json with number of entries left so that I can hide the button
$_SESSION['view']->fetchDiary();
# inefficient AF, since I need to re-type the
View::jQueryFunctions();