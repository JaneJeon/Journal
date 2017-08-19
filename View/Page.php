<?php

class Page {
	private $title;
    private $prefix;
    private $links = ['Add Entry' => '/View/add.php',
                      'View Entries' => '/View/view.php'];
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
			<title><?= $this->title ?></title>
			<link rel="stylesheet" href="../Resources/site.css">
		</head>
		<body> <?php
    }
    
    public function displayHeader() {
		$this->displayNavless();
		$this->displayNavBar();
	}
    
    private function displayNavBar() {
        echo "<nav><ul>";
        foreach ($this->links as $name => $link)
            $this->displayButton($name, $link, $this->isCurrentPage($link));
        echo "</ul></nav>";
    }
    
    private function isCurrentPage($url) {
        return !(strpos($_SERVER['PHP_SELF'], $url) === false);
    }
    
    private function displayButton($name, $url, $active) {
    	echo $active ? "<li><a href='$url' class='active'>$name</a></li>"
					 : "<li><a href='$url'>$name</a></li>";
    }
    
    public function displayFooter() {
    	if ($this->loggedIn)
			echo '<footer><a href="logout.php">Logout</a></footer>'; ?>
		</body>
		</html> <?php
    }
}