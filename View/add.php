<?php
session_start();
require_once '../functions.php';

SessionManager::checkUser($_SESSION);
$output = Input::enter($_POST, $_SESSION);

$p = new Page('Journal entry', true);
$p->displayHeader();
echo $output; ?>

<h1>Diary/Mood Entry for <?= htmlspecialchars($_SESSION['valid_user']) ?></h1>

<div class="container">
	<form action="add.php" method="post">
		<div class="form-group">
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input class="form-check-input" type="radio" name="type" id="type" value="Diary" checked> Diary
				</label>
			</div>
			<div class="form-check form-check-inline">
				<label class="form-check-label">
					<input class="form-check-input" type="radio" name="type" id="type" value="Mood"> Mood
				</label>
			</div>
		</div>
		<div class="form-group entry" id="Diary-form">
			<label for="Diary-input" class="col-form-label">Type in diary entry for today</label>
			<textarea name="Diary-input" class="form-control" id="Diary-input" rows="5" autofocus></textarea>
		</div>
		<div class="form-group row entry" id="Mood-form" style="display: none">
			<label for="Mood-select" class="col-sm-2">Select mood value</label>
			<div class="col-sm-2">
				<select class="form-control" id="Mood-select" name="Mood-input">
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
				</select>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-sm-10">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</form>
</div>

<script>
	$(function() {
		$("input[name$='type']").click(function() {
			var str = $(this).val() + "-form";
			$("div.entry").hide();
			$("#"+str).show();
		});
	})
</script>

<?php $p->displayFooter();