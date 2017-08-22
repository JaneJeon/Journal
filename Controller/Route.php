<?php

class Route {
    # routes that automatically redirect
    private static $autoRoute = ['login' => 'add',
                                 'register' => 'add',
                                 'add' => 'view',
                                 'test' => 'test',
                                 'default' => 'login'];
    
    public static function redirect($url = 'default') {
        header('Location: '.Route::$autoRoute[$url].'.php');
        exit;
    }
    
//    public static function next($url) {
//        return 'Location: '.Routes::$autoRoute[$url].'.php';
//    }
}