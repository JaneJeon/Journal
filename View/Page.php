<?php

class Page {
	private $title;
    private $prefix;
    private $links = ['Add Entry' => 'add.php',
                      'View Entries' => 'view.php'];
    private $loggedIn;
    
    public function __construct($title, $loggedIn) {
        $this->prefix = $_SERVER['DOCUMENT_ROOT'];
        $this->title = $title;
        $this->loggedIn = $loggedIn;
    }
    
    # TODO: format h1's and error p's CSS
    public function displayNavless() { ?>
		<!DOCTYPE HTML>
		<html>
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<title><?= $this->title ?></title>
			<link rel="stylesheet" href="../Resources/bootstrap.min.css">
		</head>
		<body> <?php
    }
    
    public function displayHeader() {
		$this->displayNavless();
		$this->displayNavBar();
	}
    
    private function displayNavBar() { ?>
		<nav class='navbar navbar-expand-lg navbar-light bg-light'>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<?php $this->displayButtons() ?>
				</ul>
				<form class="form-inline" action="view.php" method="post">
					<input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
			</div>
		</nav> <?php
    }
    
    private function isCurrentPage($url) {
        return !(strpos($_SERVER['PHP_SELF'], $url) === false);
    }
    
    private function displayButtons() {
    	foreach ($this->links as $name => $link)
            $this->displayButton($name, $link, $this->isCurrentPage($link));
	}
    
    private function displayButton($name, $url, $active) {
    	echo $active ? "<li class='nav-item active'>
							<a class='nav-link' href='$url'>$name<span class='sr-only'>(current)</span></a></li>"
					 : "<li class='nav-item'>
							<a class='nav-link' href='$url'>$name</a></li>";
    }
    
    public function displayFooter() {
    	if ($this->loggedIn)
			echo '<footer><a href="logout.php">Logout</a></footer>'; ?>
		</body>
		</html> <?php
    }
}