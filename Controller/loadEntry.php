<?php
require_once '../functions.php';
session_start();

$_SESSION['view']->fetchDiary();