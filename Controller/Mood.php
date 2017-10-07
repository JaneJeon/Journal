<?php
require_once '../functions.php';
require_once '../vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;

class Mood {
	const DEFAULT_INTERVAL = 30; # in number of days
	const WIDTH = 1600;
	const HEIGHT = 800;
	const BAR_X = self::WIDTH / self::DEFAULT_INTERVAL;
	const BAR_H = self::HEIGHT / 5;
	
	# return mood graph
	public static function graph($user) {
		$img = Image::canvas(self::WIDTH, self::HEIGHT);
		$start = (new DateTime())
			->sub(date_interval_create_from_date_string(self::DEFAULT_INTERVAL . ' days'));
		$moods = Entry::moodHistory($user, $start->format('Y-m-d'));
		
		for ($i = 0; $i < 5; $i++)
			$img->line(0, $i * self::BAR_H + self::BAR_H/2,
				self::WIDTH, $i * self::BAR_H + self::BAR_H/2, function ($draw) {
					$draw->color('#dddddd');
				});
		
		while ($mood = $moods->fetch_row()) {
			$score = $mood[1];
			$date = date_create($mood[0]);
			
			# A BUG WITH PHP'S BUILT-IN FUNCTION `DATE_DIFF`:
			# IT IS ACTUALLY ONE SMALLER THAN IT'S SUPPOSED TO BE.
			# SO FOR INSTANCE, DATE DIFF OF 2017 SEPT 03 AND 2017 SEPT 05 RETURNS 1.
			# HOWEVER, IT RETURNS 0 FOR DATE DIFF OF 2017 SEPT 03 AND 20017 SEPT 03.
			# THUS, WE NEED TO SEPARATE THESE CASES FOR PHP'S FUCKUP
			if ($mood[0] == $start->format('Y-m-d'))
				$diff = 0;
			else
				$diff = date_diff($start, $date)->days + 1;
			
			$img->rectangle($diff * self::BAR_X, (5 - $score) * self::BAR_H + self::BAR_H/2,
				($diff + 1) * self::BAR_X, self::HEIGHT, function ($draw) {
					$draw->background([20, 20, 180]);
				});
			
			$img->text($date->format('m-d-y'), $diff * self::BAR_X + self::BAR_X * 2/3, self::HEIGHT - 2,
				function($font) {
					$font->file('../Resources/Arial.ttf');
					$font->color('#ffaaaa');
					$font->size(18);
					$font->angle(90);
			});
		}
		
		$img->save('mood.png');
	}
}