<?php
session_start();
$actual = isset($_SESSION['valid_user']) && $_SESSION['valid_user'];
session_destroy();
?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
</head>
<body>
<h1>Logout</h1>
<?php
if ($actual) { ?>
<p class="notice">Logged out successfully.</p>
<?php } else { ?>
<p class="error">You were not logged in to begin with.</p>
<?php } ?>
<a href="login.php">Back to main page</a>
</body>
</html>