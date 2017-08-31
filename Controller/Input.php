<?php
require_once '../functions.php';

class Input {
    # intention:
    # during the first visit, DON'T try to validate input (there won't be any)
    # on subsequent visits, DO validate input.
    # if correct, add the entry then send off to view page (redirect)
    # if not, show the error message
    # keep track of whether they have tried or not
    
    # sol'n: if post is empty, DON'T do anything
    
    public static function enter($post, $session) {
        if (!isset($post['type'], $post['Diary-input'], $post['Mood-input']))
            return '';
        
        try {
            if (!($input = $post[$post['type'].'-input']))
                throw new Exception('Input is empty.<br>Please try again.');
            
            switch ($post['type']) {
                case 'Diary':
                    $success = Entry::addDiary($input, $session['valid_user']);
                    break;
                case 'Mood':
                    if (!ctype_digit($input) || $input > 5 || $input < 1)
                        throw new Exception('Mood value should be an integer between 1 and 5.');
                    
                    if (Entry::moodExists($session['valid_user']))
                        throw new Exception('An entry already exists for today.');
                    
                    $success = Entry::addMood($input, $session['valid_user']);
                    break;
                default:
                    throw new Exception('Invalid input type.<br>Make sure to select type from the dropdown.');
            }
            
            if (!$success)
                throw new Exception('Could not be entered right now.<br>Please try again later.');
            
            Route::redirect('add');
            return ''; // to appease the IDE gods
        } catch (Exception $e) {
            return '<p class="error">'.$e->getMessage().'</p>';
        }
    }
}