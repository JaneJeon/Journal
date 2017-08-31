<?php
require_once '../functions.php';

class Account {
    public static function check_password($input) {
//        return isset($input['pw']) && $input['pw'] == 'agony';
        if (!isset($input['pw']))
            return false;
        $password_set = DB::getConnection()->query('SELECT * FROM Users');
        while ($row = $password_set->fetch_row())
            if (password_verify($input['pw'], $row[1]))
                return $row[0];
        return false;
    }
    
    public static function create($username, $password) {
        try {
            if ($username === '' || $password === '')
                throw new Exception('Username/password cannot be empty.');
            
            if (strlen($username) > 20)
                throw new Exception('Username must be under 20 characters long.');
            
            if (strlen($password) < 10 || strlen($password) > 32)
                throw new Exception('Password must be between 10 and 32 characters long.');
            
            $users = DB::getConnection()->query('SELECT LOWER(user) FROM Users');
            while ($row = $users->fetch_row()) {
                if ($row[0] == strtolower($username))
                    throw new Exception('Username is already taken.');
            }
            
            $hash = password_hash($password, PASSWORD_BCRYPT);
            $stmt = DB::getConnection()->prepare("INSERT INTO Users VALUES (?, ?)");
            $stmt->bind_param('ss', $username, $hash);
            if (!$stmt->execute())
                throw new Exception('Could not create user account.<br>Please try again later.');
            
            return 0;
        } catch (Exception $e) {
            return '<p class="error">'.$e->getMessage().'</p>';
        }
    }
    
    public static function pw_exists($pw) {
        $stmt = DB::getConnection()->prepare('SELECT COUNT(*) FROM Users WHERE hash = ?');
        $stmt->bind_param('s', password_hash($pw, PASSWORD_BCRYPT));
        $stmt->execute();
        return $stmt->get_result()->fetch_row()[0];
    }
}