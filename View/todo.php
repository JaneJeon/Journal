<?php
session_start();
require_once '../functions.php';

SessionManager::checkUser($_SESSION);
$p = new Page('Journal entry', true);
$p->displayHeader();