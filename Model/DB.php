<?php
require_once '../Config.php';

// singleton database connection object
class DB {
    private static $instance = NULL;
    
    private function __construct() {}
    
    private function __clone() {}
    
    public static function getConnection() {
        if (!isset(self::$instance))
            self::$instance = new mysqli(DB::val('host'), DB::val('username'), DB::val('password'), 'Journal');
        return self::$instance;
    }
    
    private static function val($field) {
        return constant("Config::$field");
    }
}