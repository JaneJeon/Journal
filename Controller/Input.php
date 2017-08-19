<?php
require_once '../functions.php';

class Input {
    private $user;
    private $post;
    private $session;
    
    public function __construct(&$session, $post) {
        $this->user = $post['valid_user'];
        $this->post = $post;
        $this->session = $session;
    }
    
    public function entryBody() {
        try {
            if ($this->session['inputTries'] == 1)
                return;
            
            if (!isset($this->post['type'], $this->post['input']))
                throw new Exception('You have not entered all required details.<br />Please try again.');
            
            if ((!$input = $this->post['input']))
                throw new Exception('Input is empty.<br />Please try again.');
            
            switch ($this->post['type']) {
                case 'Diary':
                    $success = Entry::addDiary($input, $this->user);
                    break;
                case 'Mood':
                    if (!ctype_digit($input) || $input > 5 || $input < 1)
                        throw new Exception('Mood value should be an integer between 1 and 5.');
                    $success = Entry::addDiary($input, $this->user);
                    break;
                default:
                    throw new Exception('Invalid input type.<br />Make sure to select type from the dropdown.');
            }
            
            if (!$success)
                throw new Exception('Could not be entered right now.<br />Please try again later.');
            
            # success!
            $this->session['inputTries'] = 0;
        } catch (Exception $e) {
            if ($this->session['inputTries'] != 1)
                echo '<p class="error">'.$e->getMessage().'</p>';
            $this->session['inputTries']++;
        }
    }
    
    public function entryCheck() {
        if (!isset($this->session['inputTries']))
            $this->session['inputTries'] = 1;
        else if (!$this->session['inputTries'])
            Routes::redirect('add');
    }
}