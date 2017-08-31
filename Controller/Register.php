<?php
require_once '../functions.php';

class Register {
    private static function input($post, &$session) {
        if (!isset($post['username'], $post['pw'], $post['pw_check']))
            return '<p class="error">One or more fields is empty.<br>Please try again.</p>';
        else if ($post['pw'] != $post['pw_check'])
            return '<p class="error">The password check does not match the password.</p>';
        else if (Account::pw_exists($post['pw']))
            return '<p class="error">The account could not be created.<br>Please try again later.</p>';
        else {
            if (!($result = Account::create($post['username'], $post['pw'])))
                $session['register_attempts'] = -1;
            else
                return $result;
        }
        return 0;
    }
    
    public static function attempt($post, &$session) {
        if (!isset($session['register_attempts']))
            $session['register_attempts'] = 1;
        
        if ($session['register_attempts'] != 1)
            $output = Register::input($post, $session);
        
        $session['register_attempts']++;
    
        if (!$session['register_attempts'])
            Route::redirect('register');
        
        return isset($output) ? $output : '';
    }
}