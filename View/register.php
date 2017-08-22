<?php
require_once '../functions.php';
session_start();

$output = Register::attempt($_POST, $_SESSION);
$p = new Page('Register', false);
$p->displayNavless();
echo $output; ?>

<h1>Create an Account</h1>
<div class="container">
	<form action="register.php" method="post">
		<div class="form-group row">
			<div class="col-sm-3"></div>
			<label for="username" class="col-sm-2 col-form-label">Username</label>
			<div class="col-sm-4">
				<input type="text" name="username" id="username" class="form-control"
					   placeholder="Enter username (up to 10 characters long)">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-3"></div>
			<label for="password" class="col-sm-2 col-form-label">Password</label>
			<div class="col-sm-4">
				<input type="password" name="pw" id="password" class="form-control" placeholder="Password">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-3"></div>
			<label for="password_check" class="col-sm-2 col-form-label">Check password</label>
			<div class="col-sm-4">
				<input type="password" name="pw_check" id="password_check" class="form-control"
					   placeholder="Re-type password">
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-10">
				<button type="submit" class="btn btn-primary">Register</button>
			</div>
		</div>
	</form>
</div>

<?php $p->displayFooter();