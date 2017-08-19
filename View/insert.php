<?php
session_start();
require_once '../functions.php';

SessionManager::checkUser($_SESSION) ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <title>Journal entry results</title>
</head>
<body>
<h1>Journal entry results</h1>
<?php
try {
    if (!isset($_POST['type'], $_POST['input'])) throw new Exception
		('<p class="error">You have not entered all required details.<br />Please try again.</p>');
    
    if (!($input = $_POST['input'])) throw new Exception
		('<p class="error">Input is empty.<br />Please try again.</p>');
    $type = $_POST['type'];
    $user = $_SESSION['valid_user'];
    
    switch ($type) {
        case 'Diary':
            echo Entry::addDiary($input, $user)
                    ? '<p class="notice">Entered diary for today.</p>'
                    : '<p class="error">Entry failed.</p>';
            break;
		case 'Mood':
            if (!ctype_digit($input) || $input > 5 || $input < 1) throw new Exception
				('<p class="error">Mood value should be an integer between 1 and 5.</p>');
            echo Entry::addMood($input, $user)
                    ? '<p class="notice">Entered mood for today.</p>'
                    : '<p class="error">Entry failed.</p>';
            break;
        default:
            echo '<p class="error">Invalid input type.<br />Make sure to select type from the dropdown</p>';
	}
} catch (Exception $e) {
	echo $e->getMessage();
} ?>
<a href="login.php">Back to main page</a>
</body>
</html>