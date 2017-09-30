<?php
session_start();
require_once '../functions.php';

SessionManager::checkUser($_SESSION);
$output = Pills::enter($_POST);

$p = new Page('Track and Record Pills', true);
$p->displayHeader();
echo $output; ?>

<h1>Track and Record Pills</h1>
<div class="container">
    <h2>Current Prescriptions</h2>
    <?= Pills::prescriptions() ?>
    <form action="pills.php" method="post">
        <p>Did you take your pills for today?</p>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="taken" value="1" checked>yes
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="taken" value="0">no
            </label>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
</div>

<?php $p->displayFooter();