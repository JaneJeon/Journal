<?php
require '../functions.php';

try {
	# catch pill log up to date
	if (!($lastDate = DB::pillDB()->query('SELECT MAX(Date) FROM Log')->fetch_row()[0]))
		throw new Exception(DB::pillDB()->error);
	$today = date('Y-m-d');
	$resultSet = DB::pillDB()->query('SELECT * FROM Prescription');
	while ($row = $resultSet->fetch_row()) {
		list($name, $amount, $mg, $freq) = $row;
		for ($date = addDate($lastDate, $freq); $date < $today; $date = addDate($date, $freq)) {
			$stmt = "INSERT INTO Log VALUES (?, ?, ?, ?)";
			$stmt = DB::pillDB()->prepare('INSERT INTO Log VALUES (?, ?, ?, ?)');
			$stmt->bind_param('siis', $name, $amount, $mg, $date);
			if (!$stmt->execute()) echo htmlspecialchars($stmt->error)."<br>";
		}
	}
} catch (Exception $e) {
	echo $e->getMessage();
}
echo "success";

function addDate($date, $interval) {
	return (new DateTime($date))
		->add(new DateInterval('P'.$interval.'D'))
		->format('Y-m-d');
}