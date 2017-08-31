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
    
    public function displayNavless() { ?>
		<!DOCTYPE HTML>
		<html>
		<head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title><?= $this->title ?></title>
            <link rel="stylesheet" href="../Resources/bootstrap.min.css">
            <link rel="stylesheet" href="../Resources/site.css">
            <?= $this->specialCSS() ?>
            <script src="../Resources/jquery.min.js"></script>
		</head>
		<body> <?php
    }
    
    public function displayHeader() {
		$this->displayNavless();
		$this->displayNavBar();
	}

	# TODO: show menu when clicked on small screen button
    private function displayNavBar() { ?>
		<nav class='navbar navbar-expand-lg navbar-light bg-light'>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
							 aria-controls="navbarNav" aria-expanded="false">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<?php $this->displayButtons() ?>
				</ul>
			</div>
			<form class="form-inline" action="search.php" method="get">
				<input class="form-control mr-sm-2" type="text" placeholder="Search">
			</form>
		</nav>
		<script>
			$('form').submit(function(e) {
				if ($(this).find('input').val() === '')
					e.preventDefault();
			})
		</script>
		<?php
    }

    private function specialCSS() {
        return ($this->title == 'Login' || $this->title == 'Register')
            ? '<style> body {display: flex; align-items: center;} </style>' : '';
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