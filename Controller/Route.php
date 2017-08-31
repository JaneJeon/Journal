<?php

class Route {
    # routes that automatically redirect
    private static $autoRoute = ['login' => 'add',
                                 'register' => 'add',
                                 'add' => 'view',
                                 'test' => 'test',
                                 'default' => 'login'];
    
    public static function redirect($url = 'default') {
        $next = array_key_exists($url, Route::$autoRoute)
            ? Route::$autoRoute[$url] : 'default';
        header("Location: $next.php");
        exit;
    }
}