<?php
require_once '../functions.php';
require_once '../vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;

class Mood {
	const DEFAULT_INTERVAL = 30; # in number of days
	const WIDTH = 800;
	const HEIGHT = 400;
	const BAR_X = self::WIDTH / (self::DEFAULT_INTERVAL + 2);
	const BAR_H = self::HEIGHT / 5;
	
	# return mood graph
	public static function graph($user) {
		$img = Image::canvas(self::WIDTH, self::HEIGHT);
		$start = (new DateTime())
			->sub(date_interval_create_from_date_string(self::DEFAULT_INTERVAL . ' days'));
		$moods = Entry::moodHistory($user, $start->format('Y-m-d'));
		
		while ($mood = $moods->fetch_row()) {
			$score = $mood[1];
			$date = date_create($mood[0]);
			$diff = date_diff($start, $date)->days + 1;
			
			$img->rectangle($diff * self::BAR_X, (5 - $score) * self::BAR_H + self::BAR_H/2,
				($diff + 1) * self::BAR_X, self::HEIGHT, function ($draw) {
					$draw->background([20, 20, 180]);
				});
		}
		
		$img->save('mood.png');
	}
}