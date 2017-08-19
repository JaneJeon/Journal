<?php
require_once '../functions.php';
session_start();

$output = Register::attempt($_POST, $_SESSION);
$p = new Page('Register', false);
$p->displayNavless();
echo $output; ?>

<h1>Create an Account</h1>
<form action="register.php" method="post">
    <label for="username">Username</label>
    <input type="text" name="username" id="username" size="30"/><br />
    
    <label for="password">Password</label>
    <input type="password" name="pw" id="password" size="30"/><br />
    
    <label for="password_check">Enter password again</label>
    <input type="password" name="pw_check" id="password_check" size="30"/>
    
    <p class="input"><input type="submit" value="Submit"/></p>
</form>

<?php $p->displayFooter();