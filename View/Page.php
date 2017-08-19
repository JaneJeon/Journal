<?php

class Page {
	private $title;
    private $prefix;
    private $links = ['Home' => '/index.html',
                      'Add Entry' => '/View/login.php',
                      'View Entries' => '/View/record.php'];
    public $loggedIn = false;
    
    public function __construct($title) {
        $this->prefix = $_SERVER['DOCUMENT_ROOT'];
        $this->title = $title;
    }
    
    public function displayHeader() { ?>
		<!DOCTYPE HTML>
		<html>
		<head>
			<meta charset="UTF-8">
			<title><?= $this->title ?></title>
			<link rel="stylesheet" href="site.css">
		</head>
		<body>
		<?php $this->displayNavBar();
	}
    
    private function displayNavBar() {
        echo "<nav>\n<ul>";
        foreach ($this->links as $name => $link)
            $this->displayButton($name, $link, $this->isCurrentPage($link));
        echo "</ul>\n</nav>";
    }
    
    private function isCurrentPage($url) {
        return !(strpos($_SERVER['PHP_SELF'], $url) === false);
    }
    
    # TODO
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