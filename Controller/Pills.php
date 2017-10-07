<?php
require_once '../functions.php';

class Pills {
	public static function enter($post) {
		if (!isset($post['taken']))
			return '';
		
		if (!$post['taken'])
			return "<p>Go take your pills for today.</p>";
		
		try {
			if (($date = Pill::lastTaken()) === false)
				throw new Exception("Already took the pills for today.");
			
			if (count($pills = self::takeDay())) {
				foreach ($pills as $pill)
					if (!Pill::addRecord($pill[0], $pill[1], $pill[2]))
						throw new Exception("There was an error.<br>Please try again later.");
			} else
				throw new Exception("There are no pills to take today.");
			
			return '<p class="notice">Good job!</p><script>$(function () {$("form").hide()})</script>';
		} catch (Exception $e) {
			return '<p class="error">' . $e->getMessage() . '</p>';
		}
	}
	
	private static function takeDay() {
		$list    = Pill::pillList();
		$to_take = [];
		
		while ($pill = $list->fetch_row())
			if (Pill::pillInterval($pill[0]) >= $pill[3])
				$to_take[] = $pill;
		
		return $to_take;
	}
	
	public static function prescriptions() {
		$prescriptions = Pill::pillList();
		$table = "<table><th>Pill</th><th>Amount</th><th>mg</th><th>Every ? day(s)</th>";
		while ($pill = $prescriptions->fetch_row()) {
			$table = $table."<tr>";
			foreach ($pill as $key => $value)
				$table = $table . "<td>" . $value . "</td>";
			$table = $table."</tr>";
		}
		return $table."</table>";
	}
}