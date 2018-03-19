<?php
require_once 'DB.php';

class Pill {
	public static function pillList() {
		return DB::pillDB()->query("SELECT * FROM Prescription");
	}
	
	public static function pillInterval($pill) {
		$stmt = DB::pillDB()->prepare("SELECT DATEDIFF(CURDATE(), MAX(date)) FROM Log WHERE name = ?");
		$stmt->bind_param('s', $pill);
		$stmt->execute();
		
		return $stmt->get_result()->fetch_row()[0];
	}
	
	# TODO: allow direct editing of these values
	public static function addPill($name, $num, $mg, $freq) {
		$stmt = DB::pillDB()->prepare("INSERT INTO Prescription VALUES (?, ?, ?, ?)");
		$stmt->bind_param('siii', $name, $num, $mg, $freq);
		return $stmt->execute();
	}
	
	public static function removePill($name) {
		$stmt = DB::pillDB()->prepare("DELETE FROM Prescription WHERE name = ?");
		$stmt->bind_param('s', $name);
		return $stmt->execute();
	}
	
	# TODO
	public static function editPill($index, $param) {}
	
	public static function addRecord($name, $num, $mg) {
		$stmt = DB::pillDB()->prepare(
			"INSERT INTO Log (Name, Amount_number, Amount_mg, Date) VALUES (?, ?, ?, CURDATE())"
		);
		$stmt->bind_param('sii', $name, $num, $mg);
		
		return $stmt->execute();
	}
	
	public static function lastTaken() {
		return DB::pillDB()->query("SELECT MAX(Date) FROM Log")->fetch_row()[0];
	}
}