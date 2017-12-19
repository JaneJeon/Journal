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
    <p>Current Prescriptions</p>
    <?= Pills::prescriptions() ?><br>
    <p class="optional">Pill last taken on <?= Pill::lastTaken() ?></p>
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
<!--				TODO: why does nginx freak out when using some of the btn classes?-->
				<button class="btn btn-outline-success" id="catchup">Catch up</button>
            </div>
        </div>
    </form>
</div>

<script>
	$(function() {
		$("#catchup").click(function(e) {
			e.preventDefault()
			$.get('../scripts/catchup.php', function(data, status) {
				if (data === "success") {
					$("#catchup").remove()
					alert('Successfully caught up!')
				} else
					$(".container").append("<p class='error'>There was an error. Please try again later.</p>")
			})
		})
	})
</script>

<?php $p->displayFooter();