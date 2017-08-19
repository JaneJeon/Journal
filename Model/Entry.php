<?php
require_once 'DB.php';

class Entry {
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
}