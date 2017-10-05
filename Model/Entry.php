<?php
require_once 'DB.php';

class Entry {
	const SCORE = 0;
	const DATE = 1;
	const LIMIT = 2;
	
	public static function addDiary($input, $user) {
		$stmt = DB::getConnection()->prepare('INSERT INTO Diary (entry, user) VALUES (?, ?)');
		$stmt->bind_param('ss', $input, $user);
		
		return $stmt->execute();
	}
	
	public static function addMood($input, $user) {
		$stmt = DB::getConnection()->prepare('INSERT INTO Mood VALUES (CURDATE(), ?, ?)');
		$stmt->bind_param('is', $input, $user);
		
		return $stmt->execute();
	}
	
	public static function moodExists($user) {
		$stmt = DB::getConnection()->prepare('SELECT COUNT(*) FROM Mood WHERE day = CURDATE() AND user = ?');
		$stmt->bind_param('s', $user);
		$stmt->execute();
		
		return $stmt->get_result()->fetch_row()[0];
	}
	
	public static function getDiaryByDate($user, $posts = ['']) {
		$stmt = DB::getConnection()->prepare(
			'SELECT inserted_at, entry FROM Diary
			WHERE user = ?
			AND inserted_at NOT IN ' . self::post2list($posts) . '
			ORDER BY 1 DESC
			LIMIT ' . Entry::LIMIT
		);
		$stmt->bind_param('s', $user);
		$stmt->execute();
		
		return $stmt->get_result();
	}
	
	public static function getDiaryBySearch($user, $text, $posts = ['']) {
		$stmt = DB::getConnection()->prepare(
			'SELECT inserted_at, entry, MATCH(entry) AGAINST(?) AS score FROM Diary
			WHERE user = ?
			AND inserted_at NOT IN ' . self::post2list($posts) . '
			ORDER BY ROUND(score, 2) DESC, 1 DESC
			LIMIT ' . Entry::LIMIT
		);
		$stmt->bind_param('ss', $text, $user);
		$stmt->execute();
		
		return $stmt->get_result();
	}
	
	private static function post2list($posts) {
		$list = '(';
		foreach ($posts as $post)
			$list = "$list'$post',";
		
		return substr($list, 0, -1) . ')';
	}
	
	public static function numDiary($user) {
		$stmt = DB::getConnection()->prepare('SELECT COUNT(*) FROM Diary WHERE user = ?');
		$stmt->bind_param('s', $user);
		$stmt->execute();
		
		return $stmt->get_result()->fetch_row()[0];
	}
	
	public static function moodHistory($user, $start) {
		$stmt = DB::getConnection()->prepare(
			"SELECT day, score FROM Mood
			WHERE user = ?
			AND day > {$start}
			ORDER BY day DESC"
		);
		$stmt->bind_param('s', $user);
		$stmt->execute();
		
		return $stmt->get_result();
	}
	
	/* ------------------- pills ------------------- */
	
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
	
	public static function editPill($index, $param) {}
	
	public static function addRecord($name, $num, $mg) {
		$stmt = DB::pillDB()->prepare(
			"INSERT INTO Log (Name, Amount_number, Amount_mg, Date) VALUES (?, ?, ?, CURDATE())"
		);
		$stmt->bind_param('sii', $name, $num, $mg);
		
		return $stmt->execute();
	}
	
	public static function lastTaken() {
		if (DB::pillDB()->query("SELECT COUNT(*) FROM Log WHERE date = CURDATE()")->fetch_row()[0])
			return false;
		
		return DB::pillDB()->query("SELECT MAX(Date) FROM Log")->fetch_row()[0];
	}
}