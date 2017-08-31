<?php

class View {
    private $user;
    private $posts;
    
    public function __construct($user) {
        $this->user = $user;
        $this->posts = [];
    }
    
    public function fetchDiary() {
    	    $entries = $this->posts ? Entry::getDiaryByDate($this->user, $this->posts)
							   : Entry::getDiaryByDate($this->user);
	    
    	    while ($entry = $entries->fetch_row()) {
    	        $this->posts[] = $entry[0];
             // 0 is date, 1 is content ?>
            <div class="superContainer">
                <div class="post">
                    <div class="comment col-md-8">
                        <span class="date sub-text"><?= $entry[0] ?></span>
                        <p><?= nl2br(htmlspecialchars($entry[1])) ?></p>
                    </div>
                </div>
                <div class="post">
                    <form class="form col-md-8">
                        <div class="form-group">
                            <textarea class="form-control" rows="4" placeholder="Post a comment..."></textarea>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-sm btn-outline-dark">Submit</button>
                        </div>
                    </form>
                </div>
            </div> <?php
        }
    }
}