<?php
require_once 'DB.php';

class AccountManager {
    public static function check_password($input) {
//        return isset($input['pw']) && $input['pw'] == 'agony';
        if (!isset($input['pw'])) return false;
        $password_set = DB::getConnection()->query('SELECT * FROM Users');
        while ($row = $password_set->fetch_row())
            if (password_verify($input['pw'], $row[1]))
                return $row[0];
        return false;
    }
    
    public static function create_user($username, $password) {
        if ($username === '') throw new Exception ('<p class="error">Username cannot be empty.</p>');
        $hash = password_hash($password, PASSWORD_BCRYPT);
        
        if (!DB::getConnection()->query("INSERT INTO Users VALUES ('$username', '$hash')")) throw new Exception
            ('<p class="error">Could not create user account.<br />Please try again later.</p>');
    }
}