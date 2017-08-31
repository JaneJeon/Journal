<?php
require_once '../functions.php';

class SessionManager {
    # prevent users from accessing pages that depend on the user data when they're not logged in
    public static function checkUser($session) {
        if (!isset($session['valid_user']))
            Route::redirect();
    }
    
    # used only by the login page
    public static function authenticate(&$session, $post) {
        if ((!isset($session['valid_user']) || !$session['valid_user'])
            && !($session['valid_user'] = Account::check_password($post)))
            unset($session['valid_user']);
        
        if (!isset($session['login_attempts']) || $session['valid_user'])
            $session['login_attempts'] = 0;
        else if (isset($post['pw']))
            $session['login_attempts']++;
        
        if ($session['valid_user'])
            Route::redirect('login');
        else if ($session['login_attempts'] >= 3)
            SessionManager::sendBomb();
    }
    
    private static function sendBomb(){
        //prepare the client to receive GZIP data. This will not be suspicious
        //since most web servers use GZIP by default
        header("Content-Encoding: gzip");
        header("Content-Length: ".filesize('../Resources/10G.gzip'));
        //Turn off output buffering
        if (ob_get_level()) ob_end_clean();
        //send the gzipped file to the client
        readfile('../Resources/10G.gzip');
    }
}