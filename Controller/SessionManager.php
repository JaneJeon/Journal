<?php
require_once '../functions.php';

class SessionManager {
    # prevent users from accessing pages that depend on the user data when they're not logged in
    public static function checkUser($session, $url) {
        if (!isset($session['valid_user']))
            Routes::redirect($url);
    }
    
    # used only by the login page
    public static function authenticate(&$session, $post) {
        if (!isset($session['valid_user']) || !$session['valid_user'])
            $session['valid_user'] = AccountManager::check_password($post);
        
        if (!isset($session['login_attempts']) || $session['valid_user'])
            $session['login_attempts'] = 0;
        else
            $session['login_attempts']++;
        
        if ($session['valid_user'])
            Routes::redirect('login');
    }
}