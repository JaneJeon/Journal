<?php
require_once '../Model/DB.php';

class SessionManager {
    public static function checkUser($session) {
        if (!isset($session['valid_user'])) {
            header('Location: login.php');
            exit;
        }
    }
    
    public static function authenticate($session, $post) {
        if (!isset($session['valid_user']) || $session['valid_user'])
            $session['valid_user'] = AccountManager::check_password($post);
        
        if (!isset($session['login_attempts']) || $session['valid_user'])
            $session['login_attempts'] = 0;
        else
            $session['login_attempts']++;
        
        
    }
}