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
    	        self::commentContainer($entry, count($this->posts));
        }
    }

    # entry: 0 is date, 1 is content
    public static function commentContainer($entry, $postNum) { ?>
        <div class="superContainer">
            <div class="post">
                <div class="comment col-md-8">
                    <span class="date sub-text"><?= $entry[0] ?></span>
                    <p><?= nl2br(htmlspecialchars($entry[1])) ?></p>
                    <a href="#" class="reply float-right col-md-1" id="<?= $postNum ?>">Reply</a>
                </div>
            </div>
            <div class="post comment-reply" id="<?= $postNum ?>" hidden>
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

    public function remainingEntries() {
        return count($this->posts) - Entry::numDiary($this->user);
    }

    public function footerInformation() { ?>
        <button class="btn btn-block" id="loadMore">Load more entries</button>
        <?php
        self::jQueryFunctions();
    }

    public static function jQueryFunctions() { ?>
        <script id="ajax">
        $(function() {
            // delete the jquery function once new page is loaded to reduce page size
            // (although that probably doesn't matter at all)
            $('#ajax').remove();
            // hide the comment boxes, then only enable it with javascript (ie. you can't comment w/o JS)
            function hideAll() {
                $('.comment-reply').hide();
            }
            hideAll();
            // the styling is also a JS-exclusive function, to make the non-JS page feel static
            $('.reply').hover(function() {
                $(this).css({color: 'red'});
            }, function() {
                $(this).css({color: '#1E90FF'});
            });
            // allow only one reply box at a time
            $('a').click(function(e) {
                e.preventDefault();
                hideAll();
                // TODO: get id attribute of the link?
                alert($(this).id);
//            $('#'+$(this).id).show();
            });
            $('#loadMore').click(function() {
                $.get('../Controller/loadEntry.php', function(data) {
                    $('#loadMore').before(data);
                    // TODO: if there are no more posts, hide the button early
                    if (data === '')
                        $('#loadMore').hide();
                })
            });
            $('form').submit(function(e) {
                if ($(this).find('textarea').val() === '')
                    e.preventDefault()
            });
        })
        </script> <?php
    }
}